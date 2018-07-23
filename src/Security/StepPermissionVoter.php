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

declare(strict_types=1);

namespace Netzmacht\ContaoWorkflowBundle\Security;

use Netzmacht\Workflow\Flow\Step;

/**
 * Class WorkflowPermissionVoter
 *
 * @package Netzmacht\ContaoWorkflowBundle\Security
 */
final class StepPermissionVoter extends AbstractPermissionVoter
{
    /**
     * {@inheritDoc}
     */
    protected function getSubjectClass(): string
    {
        return Step::class;
    }
}
