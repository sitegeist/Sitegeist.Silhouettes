<?php
namespace Sitegeist\Silhouettes\ContentRepository;

use Neos\Flow\Annotations as Flow;
use Neos\ContentRepository\Domain\Model\NodeType;
use Neos\ContentRepository\NodeTypePostprocessor\NodeTypePostprocessorInterface;
use Neos\Utility\Arrays;

class SilhouettesNodeTypePostProcessor implements NodeTypePostprocessorInterface
{

    /**
     * @var array
     * @Flow\InjectConfiguration(package="Sitegeist.Silhouettes", path="properties")
     */
    protected $propertySilhuetteSettings;

    /**
     * Processes the given $nodeType (e.g. changes/adds properties depending on the NodeType configuration and the specified $options)
     *
     * @param NodeType $nodeType (uninitialized) The node type to process
     * @param array $configuration The node type configuration to be processed
     * @param array $options The processor options
     * @return void
     */
    public function process(NodeType $nodeType, array &$configuration, array $options)
    {
        if ($nodeType->hasConfiguration('properties')) {
            $localConfiguration = $nodeType->getConfiguration('properties');
            foreach ($localConfiguration as $propertyName => $propertyConfiguration) {
                if (
                    $silhouettePath = Arrays::getValueByPath($propertyConfiguration, 'options.silhouette')
                ) {
                    $silhouetteConfiguration = Arrays::getValueByPath($this->propertySilhuetteSettings, $silhouettePath);
                    if ($silhouetteConfiguration) {
                        $mergedPropertyConfiguration = Arrays::arrayMergeRecursiveOverrule(
                            $silhouetteConfiguration,
                            $propertyConfiguration
                        );
                        $configuration['properties'][$propertyName] = $mergedPropertyConfiguration;
                    }
                }
            }
        }
    }
}