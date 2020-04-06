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
    protected $propertySilhouetteSettings;

    /**
     * @var array
     * @Flow\InjectConfiguration(package="Sitegeist.Silhouettes", path="childNodes")
     */
    protected $childNodesSilhouetteSettings;

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
        $allowedSettings = [
            'properties' => $this->propertySilhouetteSettings,
            'childNodes' => $this->childNodesSilhouetteSettings
        ];
        foreach($allowedSettings as $pathName => $silhouetteSettings) {
            if ($nodeType->hasConfiguration($pathName)) {
                $localConfiguration = $nodeType->getConfiguration($pathName);
                foreach ($localConfiguration as $propertyName => $propertyConfiguration) {
                    if (
                      $silhouettePath = Arrays::getValueByPath($propertyConfiguration, 'options.silhouette')
                    ) {
                        $silhouetteConfiguration = Arrays::getValueByPath($silhouetteSettings, $silhouettePath);
                        if ($silhouetteConfiguration) {
                            $mergedPropertyConfiguration = Arrays::arrayMergeRecursiveOverrule(
                                $silhouetteConfiguration,
                                $propertyConfiguration
                            );
                            $configuration[$pathName][$propertyName] = $mergedPropertyConfiguration;
                        }
                    }
                }
            }
        }
    }
}
