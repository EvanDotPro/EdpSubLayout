<?php
namespace EdpSubLayout;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class Module extends AbstractPlugin implements ControllerPluginProviderInterface, BootstrapListenerInterface
{
    protected $template;

    public function __invoke($template)
    {
        $this->template = $template;
        return $this;
    }

    public function onDispatch(MvcEvent $e)
    {
        if (!$this->template) {
            return;
        }
        $result = $e->getResult();
        $model = $e->getViewModel();
        $subLayout = new ViewModel;
        $subLayout->setTemplate($this->template);
        $subLayout->addChild($result);
        $model->addChild($subLayout);
    }

    public function onBootstrap(EventInterface $e)
    {
        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), -50);
    }

    public function getControllerPluginConfig()
    {
        return array(
            'services' => array(
                'subLayout' => $this,
            ),
        );
    }
}
