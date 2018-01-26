# Sitegeist.Silhuettes

> Centralized property configuration for the Neos.ContentRepository

It is common that properties in various NodeTypes are expected to behave
identically. This is usually achieved with mixins but those are bound to
a fixed property name do not cover the case where properties with
different names share similarities.

The `Sitegeist.Silhuettes` package uses preconfigured
property-configurations from the settings in multiple NodeTypes. This
adds a way to centralize pererty-configuration for cases where mixins
are not sufficient and settings shall be synchronized betweeen
properties with different names.

The settings from the configured silhuette are merged with the
configuration that is found in the nodeType with the local configuration
taking precedence over the silhuette.

## Authors & Sponsors

* Martin Ficzel - ficzel@sitegeist.de

*The development and the public-releases of this package is generously sponsored 
by our employer http://www.sitegeist.de.*

## Usage

Settings.yaml

```yaml
Sitegeist:
   Silhuettes:
       properties:
          vendor:
              text:
                  block:
                      type: string
                      defaultValue: ''
                      ui:
                        inlineEditable: TRUE
                        aloha:
                          placeholder: i18n
                          autoparagraph: TRUE
                          'format':
                            'strong': TRUE
                            'em': TRUE
                            'u': FALSE
                            'sub': FALSE
                            'sup': FALSE
                            'del': FALSE
                            'p': TRUE
                            'h1': TRUE
                            'h2': TRUE
                            'h3': TRUE
                            'pre': TRUE
                            'removeFormat': TRUE
                          'table':
                            'table': TRUE
                          'list':
                            'ol': TRUE
                            'ul': TRUE
                          'link':
                            'a': TRUE
```

NodeTypes.yaml

```yaml
'Vendor.Package:NodeTypeName':
  properties:
    description:
      ui:
        label: 'Description'
        aloha:
          placeholder: 'please add description ... '
      options:
        silhuette: 'vendor.text.block'
```

### Predefined silhuettes

- `text.plain`: An inline editable string where no formatting is allowed.
- `text.block`: An inline editable string where only inline formatting is enabled.
- `text.free`: An inline editable string all formatting including blocks is allowed.

## Installation

Sitegeist.Monocle is available via packagist. `"sitegeist/silhuettes" : "^1.0"` to the require section of the composer.json
or run `composer require sitegeist/silhuettes`.

We use semantic-versioning so every breaking change will increase the major-version number.

## Contribution

We will gladly accept contributions. Please send us pull requests.