# rkw_basics
## 1. Features
__Detailed description coming soon...__

### 1.1 Responsive Image- Library
This extension comes with a customizable library for responsive images which can be used in your own extensions to generate responsive images.
#### 1.1.1 Basic Usage
You can either use it only with a FileReference- Uid 
```
<f:cObject typoscriptObjectPath="lib.txRkwBasics.responsiveImage" data="{page.txRkwbasicsTeaserImage.uid}" />
```
__OR__ 

with a direct path to the source image 
```
<f:cObject typoscriptObjectPath="lib.txRkwBasics.responsiveImage" data="EXT:rkw_related/Resources/Public/Images/Logo.png"/>
```
__OR__ 

by defining all params according to your needs
```
<f:cObject typoscriptObjectPath="lib.txRkwBasics.responsiveImage" data="{file: {page.txRkwbasicsTeaserImage.uid}, treatIdAsReference: 1, title: 'Titel', additionalAttributes: 'class=\"test\"'}" />
```
#### 1.1.2 Example for extended usage: Responsive images from media-field in pages
You can include the Lib into your own TypoScript and customize it according to your needs.

##### TypoScript
```
lib.txMyExtension {

    keyvisual {

        article = FLUIDTEMPLATE
        article {

            file = {$plugin.tx_myExtension.view.partialRootPath}/FluidTemplateLibs/Keyvisual/Article.html
            
            // load images from media-field of current page
            dataProcessing {
                10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
                10 {
                    references {
                        table = pages
                        fieldName = media
                    }
                    as = images
                }
            }

            // inherit all settings from responsive image lib
            settings < lib.txRkwBasics.responsiveImage.settings
            settings {

                // add class-tag
                additionalAttributes = class="article-image"
                
                // remove desktop-breakpoint because we only need 900px as maximum width
                breakpoint {
                    desktop >
                }

                // override maxWidth for tablet breakpoint  (default: 1024px)
                maxWidth {
                    tablet = 900
                }

                // set all relevant cropVariants to customized one
                cropVariant {
                    tablet = articleDesktop
                    mobile2 = articleDesktop
                    mobile = articleDesktop
                    fallback = articleDesktop
                }
            }
        }
    }
}
```
##### FluidTemplateLibs/KeyVisual/Article.html
```
<html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers" data-namespace-typo3-fluid="true">

    <f:if condition="{images.0}">
        <f:switch expression="{images.0.type}">
            <f:case value="2">
                <f:render section="Image" arguments="{file: images.0}" />
            </f:case>
            <f:case value="4">
                <f:render section="Video" arguments="{file: images.0}" />
            </f:case>
            <f:defaultCase>
                <!-- Nothing -->
            </f:defaultCase>
        </f:switch>
    </f:if>

    <!-- ======================================================================== -->

    <f:section name="Image">
        <f:cObject typoscriptObjectPath="lib.txRkwBasics.responsiveImage" data="{file: '{file.uid}', treatIdAsReference: 1, settings: settings}" />
    </f:section>

    <f:section name="Video">
        <f:media class="article-video" file="{file}" width="2000" alt="{file.alternative}" title="{file.title}" additionalConfig="{controls: '0', loop: '1', autoplay: '1', modestbranding:'1', no-cookie: '1'}" />
    </f:section>
</html>
```
##### Call via Partial
```
<html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers" data-namespace-typo3-fluid="true">

    <!-- article image or video -->
    <f:cObject typoscriptObjectPath="lib.txMyExtension.keyvisual.article" data="{data}" />

</html>
```

#### 1.1.3 Example for extended usage: Responsive images from media-field in pages with inheritance
You can include the Lib into your own TypoScript and customize it according to your needs.

##### TypoScript
```
lib.txmyExtension {

    keyvisual {

        publication = COA
        publication {

            10 = FILES
            10 {

                references {
                    table = pages
                    data = levelfield: -1, media, slide
                }

                renderObj = COA
                renderObj {

                    5 = LOAD_REGISTER
                    5 {
                        imageIdList.cObject = TEXT
                        imageIdList.cObject.data = register:imageIdList
                        imageIdList.cObject.wrap = |,{file:current:uid_local}
                        imageIdList.cObject.wrap.insertData = 1
                    }
                }
            }

            20 = FLUIDTEMPLATE
            20 {
            
                file = {$plugin.tx_myExtension.view.partialRootPath}/FluidTemplateLibs/Keyvisual/Publication.html
    
                // load images from media-field with inheritance
                dataProcessing {
                    10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
                    10 {

                        files.data = register:imageIdList
                        as = images
                    }
                }
    
                // get all settings from responsive image lib
                settings < lib.txRkwBasics.responsiveImage.settings
                settings {
    
                    // add class-tag
                    additionalAttributes = class="publications-article__picture"
                    
                    // remove desktop-breakpoint because we only need 900px as maximum width
                    breakpoint {
                        desktop >
                    }
    
                    // override maxWidth for tablet breakpoint  (default: 1024px)
                    maxWidth {
                        tablet = 900
                    }
    
                    // set all relevant cropVariants to customized one
                    cropVariant {
                        tablet = articleDesktop
                        mobile2 = articleDesktop
                        mobile = articleDesktop
                        fallback = articleDesktop
                    }
                }                         
            }
            
            90 = RESTORE_REGISTER
        }
    }
}
```
##### FluidTemplateLibs/KeyVisual/Publication.html
```
<html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers" data-namespace-typo3-fluid="true">

   <f:cObject typoscriptObjectPath="lib.txRkwBasics.responsiveImage" data="{file: '{images.0.uid}', treatIdAsReference: 0, settings: settings}" />

</html>
```
##### Call via Partial
```
<html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers" data-namespace-typo3-fluid="true">

    <!-- article image or video -->
    <f:cObject typoscriptObjectPath="lib.txMyExtension.keyvisual.publication" data="{data}" />

</html>
```

## 1.1.2. Configuration
* Per default the lib uses the following breakpoints defined via TypoScript:
```
# cat=plugin.tx_rkwbasics//a; type=integer; label=Breakpoint for desktop
desktop = 1024

# cat=plugin.tx_rkwbasics//a; type=integer; label=Breakpoint for tablet
tablet = 768

# cat=plugin.tx_rkwbasics//a; type=integer; label=Second breakpoint for mobile
mobile2 = 640

# cat=plugin.tx_rkwbasics//a; type=integer; label=First breakpoint for mobile
mobile = 320
```
* Based on the defined breakpoints it generates the following image-set:
```
* min-width: 1024px AND min-resolution: 192dpi
* min-width: 1024px
* min-width: 768px AND min-resolution: 192dpi
* min-width: 768px
* min-width: 640px AND min-resolution: 192dpi
* min-width: 640px
* min-width: 320px AND min-resolution: 192dpi
* min-width: 320px
* min-width: 0px AND min-resolution: 192dpi
* min-width: 0px (Fallback)
```    
* You can configure the usage of CropVariants per breakpoint and also set your own breakpoints and maxWidths via TypoScript

## 1.2. CDN

With the CDN functionality it is possible to reduce the loading time of the website considerably by loading static content from subdomains of the respective website.
This is not a real CDN, but a Pseudo-CDN, since no external servers are used.

Example without Pseudo-CDN
```
<picture >
    <source srcset="https://www.rkw.de/fileadmin/_processed_/e/e/csm_20191112-Unternehmensberatung-Desktop_20772b022d.jpg" media="(min-width: 1025px)">
    <source srcset="https://www.rkw.de/fileadmin/_processed_/a/2/csm_20191112-Unternehmensberatung-Tablet_e748abd11d.jpg" media="(min-width:769px)">
    <source srcset="https://www.rkw.de/fileadmin/_processed_/a/2/csm_20191112-Unternehmensberatung-Tablet_a7c14e847a.jpg" media="(min-width:481px)">
    <source srcset="https://www.rkwde/fileadmin/_processed_/4/9/csm_20191112-Unternehmensberatung-Mobile_3c8697c74b.jpg" media="(min-width:321px)">
    <source srcset="https://www.rkw.de/fileadmin/_processed_/4/9/csm_20191112-Unternehmensberatung-Mobile_f329b9da89.jpg" media="(min-width:0px)">
    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA=" alt="Ihre Unternehmensberatung ">
</picture>
```
Example with Pseudo-CDN
```
<picture >
    <source srcset="https://static1.rkw.de/fileadmin/_processed_/e/e/csm_20191112-Unternehmensberatung-Desktop_20772b022d.jpg" media="(min-width: 1025px)">
    <source srcset="https://static1.rkw.de/fileadmin/_processed_/a/2/csm_20191112-Unternehmensberatung-Tablet_e748abd11d.jpg" media="(min-width:769px)">
    <source srcset="https://static1.rkw.de/fileadmin/_processed_/a/2/csm_20191112-Unternehmensberatung-Tablet_a7c14e847a.jpg" media="(min-width:481px)">
    <source srcset="https://static2.rkwde/fileadmin/_processed_/4/9/csm_20191112-Unternehmensberatung-Mobile_3c8697c74b.jpg" media="(min-width:321px)">
    <source srcset="https://static2rkw.de/fileadmin/_processed_/4/9/csm_20191112-Unternehmensberatung-Mobile_f329b9da89.jpg" media="(min-width:0px)">
    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA=" alt="Ihre Unternehmensberatung ">
</picture>
```
### 1.2.1 Settings
```
config {
    tx_rkwbasics_cdn {

        // Activate CDN
        enable = 0

        // Maximum number of connections per domain
        maxConnectionsPerDomain = 4

        // Maximum number of subdomains
        maxSubdomains = 100

        // Ignore some files like CSS and JS because browser security stuff may cause problems
        ignoreIfContains = /\.css|\.js|\?noCdn=1/

        // Regular expression for replacement
        search = /(href="|src="|srcset=")\/?((uploads\/media|uploads\/pics|typo3temp\/compressor|typo3temp\/GB|typo3conf\/ext|fileadmin)([^"]+))/i
    }
}
```
* **enable** activates the Pseudo-CDN
* **maxConnectionsPerDomain** defines how many resources are loaded from a subdomain. 
* **maxSubdomains** defines how many sudomains there should be. If the value is set to 10 the subdomains static1.example.com to static10.example.com are used.
* **search** allows to override the regular expression for searching/replacing paths to static content
* **ignoreIfContains** allows to specify exclusion criteria for the pseudoCDN. Especially JS files should be excluded here (cross-domain issues)


Translated with www.DeepL.com/Translator (free version)

## 3. Image Protection

## 4. Breaking Changes 
### In version >= 8.7.20
* __Moved field tx_rkwbasics_teaser_image to resources-tab in page properties.__
Please adapt your permission settings in BE accordingly.

* __Removed field tx_rkwbasics_teaser_text.__
Use the UpdateWizard via InstallTool to migrate existing contents to the abstract field.

* __Removed field tx_rkwbasics_article_video.__
Use the UpdateWizard via InstallTool to migrate existing contents to the media field.
Linked YouTube links will be automatically migrated to ResourceFiles.

* __Removed field tx_rkwbasics_infomation.__
This field is removed without replacement.



