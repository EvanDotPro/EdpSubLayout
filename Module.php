<?php
namespace EdpSubLayout;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class Module extends AbstractPlugin
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

    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), -50);
    }

    public function getConfig()
    {
        return array(
            'controller_plugins' => array(
                'services' => array(
                    'subLayout' => $this,
                ),
            ),
        );
    }
}
