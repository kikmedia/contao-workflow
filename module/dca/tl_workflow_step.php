<?php

/**
 * This Contao-Workflow extension allows the definition of workflow process for entities from different providers. This
 * extension is a workflow framework which can be used from other extensions to provide their custom workflow handling.
 *
 * @package    workflow
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 */


$GLOBALS['TL_DCA']['tl_workflow_step'] = array
(
    'config' => array
    (
        'dataContainer' => 'Table',
        'ptable' => 'tl_workflow',
        'onload_callback' => array(
            array('Netzmacht\Workflow\Contao\Backend\Dca\Step', 'adjustEditMask'),
        ),
        'sql'           => array
        (
            'keys' => array
            (
                'id'  => 'primary',
                'pid' =>'index'
            )
        ),
    ),

    'list' => array
    (
        'sorting' => array
        (
            'mode'   => 4,
            'flag'   => 1,
            'headerFields' => array('label', 'name', 'type', 'description'),
            'fields' => array('name'),
            'disableGrouping' => true,
            'child_record_callback' => array(
                'Netzmacht\Workflow\Contao\Backend\Common',
                'generateRow'
            )
        ),
        'label' => array
        (
            'fields' => array('label', 'name', 'description'),
            'format' => '<strong>%s</strong> <span class="tl_gray">[%s]</span><br>%s',

        ),

        'operations' => array
        (
            'edit' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_workflow_step']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ),
            'delete' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_workflow_step']['delete'],
                'href'  => 'act=delete',
                'icon'  => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ),
            'show' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_workflow_step']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ),
        ),
    ),

    'palettes' => array(
        '__selector__' => array('limitPermission')
    ),

    'metapalettes' => array
    (
        'default' => array
        (
            'name'       => array('label', 'name', 'description', 'final'),
            'permission' => array('limitPermission'),
        ),
    ),

    'metasubpalettes' => array(
        'limitPermission' => array('permission'),
    ),

    'fields' => array
    (
        'id'             => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid'         => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp'         => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'name'           => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_step']['name'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'           => 'w50',
                'maxlength' => 64,
            ),
            'sql'       => "varchar(64) NOT NULL default ''",
        ),
        'label'           => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_step']['label'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'           => 'w50',
                'mandatory' => true,
                'maxlength' => 64,
            ),
            'sql'       => "varchar(64) NOT NULL default ''",
        ),
        'description'           => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_step']['description'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'           => 'clr long',
                'maxlength' => 255,
            ),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'final'      => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_step']['final'],
            'inputType' => 'checkbox',
            'eval'      => array(
                'tl_class'       => 'clr w50',
                'submitOnChange' => true,
            ),
            'sql'       => "char(1) NOT NULL default ''"
        ),
        'limitPermission'      => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_step']['limitPermission'],
            'inputType' => 'checkbox',
            'eval'      => array(
                'tl_class'       => 'clr w50 m12',
                'submitOnChange' => true,
            ),
            'sql'       => "char(1) NOT NULL default ''"
        ),
        'permission'      => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_step']['permission'],
            'inputType' => 'select',
            'options_callback' => array('Netzmacht\Workflow\Contao\Backend\Permission', 'getWorkflowPermissions'),
            'eval'      => array(
                'tl_class'       => 'w50',
                'mandatory' => true,
            ),
            'sql'       => "varchar(32) NOT NULL default ''"
        ),
    ),
);
