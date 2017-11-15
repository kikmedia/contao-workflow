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


$GLOBALS['TL_DCA']['tl_workflow_action'] = array
(
    'config' => array
    (
        'dataContainer' => 'Table',
        'ptable' => 'tl_workflow_transition',
        'sql'           => array
        (
            'keys' => array
            (
                'id'  => 'primary',
                'pid' => 'index'
            )
        ),
    ),

    'list' => array
    (
        'sorting' => array
        (
            'mode'   => 4,
            'flag'   => 1,
            'fields' => array('postAction', 'sorting'),
            'headerFields' => array('label', 'name', 'type', 'description'),
            'child_record_callback' => array(
                'Netzmacht\Contao\Workflow\Backend\Common',
                'generateRow'
            ),
            'panelLayout' => 'filter;search,limit'
        ),
        'label' => array
        (
            'fields' => array('name'),
            'format' => '%s',
        ),

        'operations' => array
        (
            'edit' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_workflow_action']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ),
            'delete' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_workflow_action']['delete'],
                'href'  => 'act=delete',
                'icon'  => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ),
            'toggle' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_workflow_action']['toggle'],
                'icon'       => 'visible.gif',
                'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => \Netzmacht\Contao\Toolkit\Dca::createToggleIconCallback(
                    'tl_workflow_action',
                    'active'
                )
            ),
            'show' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_workflow_action']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ),
        ),
    ),

    'palettes' => array(
        '__selector__' => array('type'),
    ),

    'metapalettes' => array
    (
        'default' => array
        (
            'name'        => array('label', 'name', 'type', 'postAction', 'logChanges', 'sorting'),
            'description' => array(':hide', 'description'),
            'config'      => array(),
            'activation'  => array('active'),
        ),
    ),

    'fields' => array
    (
        'id'             => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid'         => array
        (
            'relation' => array('type' => 'hasOne', 'load' => 'lazy'),
            'foreignKey' => 'tl_workflow_transition.name',
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting'             => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_action']['sorting'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'  => 'w50',
                'rgxp'      => 'digit',
                'maxlength' => 64,
            ),

            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp'         => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'label'           => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_action']['label'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'           => 'w50',
                'mandatory' => true,
                'maxlength' => 64,
            ),
            'sql'       => "varchar(64) NOT NULL default ''",
        ),
        'name'           => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_action']['name'],
            'inputType' => 'text',
            'exclude'   => true,
            'save_callback' => array(
                array('Netzmacht\Contao\Workflow\Backend\Common', 'createName'),
            ),
            'eval'      => array(
                'tl_class'           => 'w50',
                'maxlength' => 64,
            ),
            'sql'       => "varchar(64) NOT NULL default ''",
        ),
        'type'           => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_action']['type'],
            'inputType' => 'select',
            'exclude'   => true,
            'options_callback' => array('Netzmacht\Contao\Workflow\Backend\Dca\Action', 'getTypes'),
            'eval'      => array(
                'tl_class'           => 'w50',
                'mandatory' => true,
                'includeBlankOption' => true,
                'submitOnChange' => true,
                'chosen' => true,
            ),
            'sql'       => "varchar(32) NOT NULL default ''",
        ),
        'description'           => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_action']['description'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'           => 'clr long',
                'maxlength' => 255,
            ),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'postAction'      => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_action']['postAction'],
            'inputType' => 'checkbox',
            'exclude'   => true,
            'filter'    => true,
            'eval'      => array(
                'tl_class'       => 'w50 m12',
            ),
            'sql'       => "char(1) NOT NULL default ''"
        ),
        'logChanges'      => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_action']['logChanges'],
            'inputType' => 'select',
            'default'   => 'inherit',
            'options'   => array('inherit', 'active', 'disable'),
            'eval'      => array(
                'tl_class'       => 'w50',
                'submitOnChange' => true,
            ),
            'sql'       => "char(8) NOT NULL default 'inherit'"
        ),
        'active'      => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_workflow_action']['active'],
            'inputType' => 'checkbox',
            'eval'      => array(
                'tl_class'       => 'clr w50',
                'submitOnChange' => true,
            ),
            'sql'       => "char(1) NOT NULL default ''"
        ),
    ),
);