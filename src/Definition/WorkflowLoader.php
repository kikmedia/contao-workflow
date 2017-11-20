<?php

/**
 * This Contao-Workflow extension allows the definition of workflow process for entities from different providers. This
 * extension is a workflow framework which can be used from other extensions to provide their custom workflow handling.
 *
 * @package    workflow
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2017 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 */

namespace Netzmacht\Contao\Workflow\Definition;

use Netzmacht\Workflow\Flow\Workflow;

/**
 * Interface WorkflowLoader
 *
 * @package Netzmacht\Contao\Workflow\Definition
 */
interface WorkflowLoader
{
    /**
     * Load the workflows optional limited for a provider.
     *
     * @param string|null $providerName Provider name.
     *
     * @return Workflow[]|array
     */
    public function load(?string $providerName = null): array;
}
