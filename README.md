# Sitegeist.Silhouettes

*Neos 7.0 includes the features of Sitegeist.Silhouettes as NodeType presets.
This package will be abandoned in favor of that eventually!*

> Centralized property configuration for the Neos.ContentRepository

It is common that properties in various NodeTypes are expected to behave
identically. This is usually achieved with mixins but those are bound to
a fixed property name do not cover the case where properties with
different names share similarities.

The `Sitegeist.Silhouettes` package uses preconfigured
property-configurations from the settings in multiple NodeTypes. This
adds a way to centralize property-configuration for cases where mixins
are not sufficient and settings shall be synchronized betweeen
properties with different names.

It is also possible to create silhouettes for childNode constraint
configurations, e.g. to apply the same centralized constraints to different
childNodes following the dry principle.
This can also be useful when using a single NodeType package in different
neos instances where the constraints may differcenate.

The settings from the configured silhouette are merged with the
configuration that is found in the nodeType with the local configuration
taking precedence over the silhouette.

## Authors & Sponsors

* Martin Ficzel - ficzel@sitegeist.de

*The development and the public-releases of this package is generously sponsored
by our employer http://www.sitegeist.de.*

## Usage

Settings.yaml

```yaml
Sitegeist:
  Silhouettes:
    properties:
      vendor:
        text:
          block:
            type: string
            defaultValue: ''
            ui:
              inlineEditable: true
              inline:
                editorOptions:
                  placeholder: '(( text block ))'
                  autoparagraph: true
                  linking:
                    anchor: true
                    title: true
                    relNofollow: false
                    targetBlank: false
                  formatting:
                    strong: true
                    em: true
                    u: false
                    underline: false
                    strikethrough: false
                    sub: false
                    sup: false
                    del: false
                    p: true
                    h1: false
                    h2: false
                    h3: false
                    h4: false
                    h5: false
                    h6: false
                    pre: false
                    removeFormat: true
                    left: false
                    right: false
                    center: false
                    justify: false
                    table: false
                    ol: false
                    ul: false
                    a: true
  
      childNodes:
        vendor:
          defaultConstraints:
            constraints:
              'Neos.Neos:Content': true
              'Neos.NodeTypes.BaseMixins:TitleMixin': true
              'Neos.Demo:Constraint.Content.Carousel': true
              'Neos.Demo:Constraint.Content.Column': false
```

NodeTypes.yaml

```yaml
'Vendor.Package:NodeTypeName':
  childNodes:
    column1:
      options:
        silhouette: 'vendor.defaultConstraints'    
    column2:
      options:
        silhouette: 'vendor.defaultConstraints'    
  properties:
    description:
      ui:
        label: 'Description'
        inline:
          editorOptions:
            placeholder: 'please add description ... '
      options:
        silhouette: 'vendor.text.block'
```

### Predefined silhouettes

- `text.plain`: An inline editable string where no formatting is allowed.
- `text.block`: An inline editable string where only inline formatting is enabled.
- `text.free`: An inline editable string where all formatting including blocks is allowed.

## Installation

Sitegeist.Silhouettes is available via packagist. Add `"sitegeist/silhouettes" : "^1.0"`
to the require section of the composer.json or run `composer require sitegeist/silhouettes`.

We use semantic-versioning so every breaking change will increase the major-version number.

## Contribution

We will gladly accept contributions. Please send us pull requests.
