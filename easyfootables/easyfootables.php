<?php

defined('_JEXEC') or die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');

/**
 *
 * @author Craig Phillips
 * @copyright Copyright (C) 2012 Craig Phillips Pty Ltd - All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE file
 *
 */
 
class plgContentEasyFootables extends JPlugin
{
    protected $initScript = <<<foo
    jQuery(document).ready(function () {
        jQuery('.footable').footable();
    });
foo;


    /**
     * @access      public
     * @param       object  $subject The object to observe
     * @param       array   $config  An array that holds the plugin configuration
     */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);

        // Strictly speaking Joomla doesn't really need you to load the language anymore.
        $this->loadLanguage();
    }

    /**
     * We look for {footables} here to trigger the installation of the Footables initialisation script.
     *
     * @param   string                    The context of the content being passed to the plugin.
     * @param   object                    The article object.  Note $article->text is also available
     * @param   Joomla\Registry\Registry  The article params
     * @param   int                       The 'page' number
     *
     * @return null
     */
    public function onContentPrepare($context, &$article, &$params, $page = 0)
    {
        // Never run this plugin when the content is being indexed
        if ($context == 'com_finder.indexer') {
            return true;
        }

        // simple performance check to determine whether bot should process further
        if (strpos($article->text, '{footables') === false) {
            return true;
        }

        // Plugin expression to search for in article
        $fooStart = '/{footables\s*(.*?)}/i';

        // Find all instances of plugin and put in $matches for footable
        // $matches[0] is full pattern match, $matches[1] is the options
        preg_match_all($fooStart, $article->text, $matches, PREG_SET_ORDER);

        // If there are No matches, skip the whole process, if we have something strip our tag
        // and load all the bits.
        if ($matches) {
            // First up remove our tag
            $match = $matches[0][0];
            $article->text = preg_replace("|$match|", '', $article->text, 1);

            // Add the main FooTable CSS the to doc head.
            $minOrNot = JDEBUG ? '' : '.min';
            $doc = JFactory::getDocument();
            $doc->addStyleSheet('/media/plg_content_easyfootables/css/footable.core' . $minOrNot . '.css');

            // Custom CSS
            $customCSSEnabled = (bool) $params->get('load_css', 0);
            $customCSSPath = $params->get('custom_css_path', '');
            $cssExists = !empty($customCSSPath) ? file_exists(JPATH_ROOT . $customCSSPath) : false;

            if ($customCSSEnabled && $cssExists) {
                $doc->addStyleSheet($customCSSPath);
            }

            // Do we need jQuery?
            $load_jquery = (bool) $params->get('load_jquery', true);
            if ($load_jquery) {
                JHtml::_('jquery.framework');
            }

            // Load Footable init script and plugin
            $doc->addScriptDeclaration($this->initScript, "text/javascript");
            $doc->addScript('/media/plg_content_easyfootables/js/footable.js?v=2.0.1');

        }
    }
}
