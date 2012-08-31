<?php
/**
 * File containing the MultipleValued matcher class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\MVC\View\ContentViewProvider\Configured\Matcher;

use eZ\Publish\MVC\RepositoryAware,
    eZ\Publish\MVC\View\ContentViewProvider\Configured\Matcher;

abstract class MultipleValued extends RepositoryAware implements Matcher
{
    /**
     * @var array Values to test against with isset(). Key is the actual value.
     */
    protected $values;

    /**
     * Registers the matching configuration for the matcher.
     * $matchingConfig can have single (string|int...) or multiple values (array)
     *
     * @param mixed $matchingConfig
     * @return void
     * @throws \InvalidArgumentException Should be thrown if $matchingConfig is not valid.
     */
    public function setMatchingConfig( $matchingConfig )
    {
        $matchingConfig = !is_array( $matchingConfig ) ? array( $matchingConfig ) : $matchingConfig;
        $this->values = array_fill_keys( $matchingConfig, true );
    }
}