<?php
namespace Sitegeist\Silhouettes\ContentRepository;

use Neos\Flow\Annotations as Flow;
use Neos\ContentRepository\Domain\Model\NodeType;
use Neos\ContentRepository\NodeTypePostprocessor\NodeTypePostprocessorInterface;
use Neos\Utility\Arrays;

class SilhuettesNodeTypePostProcessor implements NodeTypePostprocessorInterface
{

    /**
     * @var array
     * @Flow\InjectConfiguration
     */
    protected $settings;

    /**
     * Processes the given $nodeType (e.g. changes/adds properties depending on the NodeType configuration and the specified $options)
     *
     * @param NodeType $nodeType (uninitialized) The node type to process
     * @param array $configuration The node type configuration to be processed
     * @param array $options The processor options
     * @return void
     */
    public function process(NodeType $nodeType, array &$configuration, array $options) {
        if ($nodeType->hasConfiguration('properties')) {
            $localConfiguration = $nodeType->getConfiguration('properties');
            foreach ($localConfiguration as $propertyName => $propertyConfiguration) {
                if (
                    $silhuettePath = Arrays::getValueByPath($propertyConfiguration, 'options.silhuette')
                ) {
                    $silhuetteConfiguration = Arrays::getValueByPath($this->settings, $silhuettePath);
                    if ($silhuetteConfiguration) {
                        $mergedPropertyConfiguration = Arrays::arrayMergeRecursiveOverrule($silhuetteConfiguration, $propertyConfiguration);
                        $configuration['properties'][$propertyName] = $mergedPropertyConfiguration;
                    }
                }
            }
        }
    }

}