<?php
/**
 * File containing the ScriptHandler class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 */

namespace eZ\Bundle\EzPublishCoreBundle\Composer;

use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as DistributionBundleScriptHandler;
use Composer\Script\Event;

class ScriptHandler extends DistributionBundleScriptHandler
{
    /**
     * Dump minified assets for prod environment under the web root directory.
     *
     * @param $event Event A instance
     */
    public static function dumpAssets( Event $event )
    {
        $options = self::getOptions( $event );
        $appDir = $options['symfony-app-dir'];
        $webDir = $options['symfony-web-dir'];
        $env = isset( $options['ezpublish-asset-dump-env'] ) ? $options['ezpublish-asset-dump-env'] : "";

        if ( !$env )
        {
            $env = $event->getIO()->ask(
                "<question>Which environment would you like to dump production assets for?</question> (Default: 'prod', type 'none' to skip) ",
                'prod'
            );
        }

        if ( $env === 'none' )
        {
            return;
        }

        if ( !is_dir( $appDir ) )
        {
            echo 'The symfony-app-dir (' . $appDir . ') specified in composer.json was not found in ' . getcwd() . ', can not install assets.' . PHP_EOL;
            return;
        }

        if ( !is_dir( $webDir ) )
        {
            echo 'The symfony-web-dir (' . $webDir . ') specified in composer.json was not found in ' . getcwd() . ', can not install assets.' . PHP_EOL;
            return;
        }

        static::executeCommand( $event, $appDir, 'assetic:dump --env=' . escapeshellarg( $env ) . ' ' . escapeshellarg( $webDir ) );
    }

    /**
     * Just dump help text on how to dump assets
     *
     * Typically to use this instead on composer update as dump command uses prod environment where cache is not cleared,
     * causing it to sometimes crash when cache needs to be cleared.
     *
     * @param $event Event A instance
     */
    public static function dumpAssetsHelpText( Event $event )
    {
        $event->getIO()->write( '<info>To dump eZ Publish production assets, execute the following:</info>' );
        $event->getIO()->write( '    php ezpublish/console assetic:dump --env=prod web' );
        $event->getIO()->write( '' );
    }
}
