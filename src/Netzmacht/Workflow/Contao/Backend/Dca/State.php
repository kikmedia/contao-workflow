<?php

/**
 * @package    workflow
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Workflow\Contao\Backend\Dca;

use Netzmacht\Workflow\Contao\ServiceProvider;
use Netzmacht\Workflow\Data\EntityId;

class State extends Base
{
    /**
     * @var ServiceProvider
     */
    private $serviceProvider;

    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->serviceProvider = ServiceProvider::create();
    }

    /**
     * Apply a filter when looking at the history.
     */
    public function applyFilter()
    {
        if (\Input::get('providerName') && \Input::get('id')) {
            $entityId = EntityId::fromProviderNameAndId(
                \Input::get('providerName'),
                \Input::get('id')
            );

            $session = \Session::getInstance();
            $filter  = $session->get('filter');

            $filter['tl_workflow_state'] = array('entityId' => (string) $entityId);
            $session->set('filter', $filter);
        }
    }


    public function generateGroupHeader($label, $foo, $column, $row)
    {
        $header = array(
            'entityId'       => $this->translate('entityId.0'),
            'workflowName'   => $this->translate('workflowName.0'),
            'transitionName' => $this->translate('transitionName.0'),
            'stepName'       => $this->translate('stepName.0'),
            'success'        => $this->translate('success.0'),
            'reachedAt'      => $this->translate('reachedAt.0'),
        );

        $template = new \BackendTemplate('be_workflow_state_row');
        $template->setData($header);

        return $label . $template->parse();
    }

    public function generateRow($row)
    {
        try {
            $entityId = EntityId::fromString($row['entityId']);
            $manager  = $this->serviceProvider->getManager($entityId->getProviderName());
            $entity   = $this->serviceProvider
                ->getEntityManager()
                ->getRepository($entityId->getProviderName())
                ->find($entityId->getIdentifier());

            $workflow = $manager->getWorkflow($entityId, $entity);

            if ($workflow) {
                $row['workflowName']   = $workflow->getLabel();
                $row['transitionName'] = $workflow->getTransition($row['transitionName'])->getLabel();
                $row['stepName']       = $workflow->getStep($row['stepName'])->getLabel();
            }
        }
        catch(\Exception $e) {}

        $row['success'] = $this->translate($row['success'] ? 'yes' : 'no', array(), 'MSC');

        $template = new \BackendTemplate('be_workflow_state_row');
        $template->setData($row);

        if (is_numeric($row['reachedAt'])) {
            $template->reachedAt = \Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $row['reachedAt']);
        }

        return $template->parse();
    }
}