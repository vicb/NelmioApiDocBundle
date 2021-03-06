<?php

/*
 * This file is part of the NelmioApiDocBundle.
 *
 * (c) Nelmio <hello@nelm.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nelmio\ApiDocBundle\Formatter;

use Symfony\Component\Templating\EngineInterface;

class HtmlFormatter extends AbstractFormatter
{
    /**
     * @var string
     */
    private $apiName;

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    private $engine;

    /**
     * @param string $apiName
     */
    public function setApiName($apiName)
    {
        $this->apiName = $apiName;
    }

    /**
     * @param EngineInterface $engine
     */
    public function setTemplatingEngine(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOne(array $data)
    {
        return $this->engine->render('NelmioApiDocBundle::resource.html.twig', array_merge(
            array('data' => $data, 'displayContent' => true),
            $this->getGlobalVars()
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function render(array $collection)
    {
        return $this->engine->render('NelmioApiDocBundle::resources.html.twig', array_merge(
            array('resources' => $collection),
            $this->getGlobalVars()
        ));
    }

    /**
     * @return array
     */
    private function getGlobalVars()
    {
        return array(
            'apiName'   => $this->apiName,
            'date'      => date(DATE_RFC822),
            'css'       => file_get_contents(__DIR__ . '/../Resources/public/css/screen.css'),
        );
    }
}
