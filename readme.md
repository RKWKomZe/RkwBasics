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

## 1.2. Pseudo-CDN

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

##  1.3 Enforced ImageRendering
Normally TYPO3 only calculates those images whose size does not fit, for example. 
For all others, however, image optimization would not work. 
Using an XClass, this extension forces ImageProcessing for all images in the Frontend, 
thus enabling uniform optimization of the images. 

Currently, this feature cannot yet be deactivated via TypoScript.


## 1.4 Enforced Inline CSS
Ideally, the CSS is output inline directly to the header of the website.
This saves reloading the CSS files and speeds up the rendering. 
From TYPO3 9 upwards, it is possible to force inline output via TypoScript, 
but this does not work for external CSS files (e.g. TypeKit) (see: https://docs.typo3.org/m/typo3/reference-typoscript/master/en-us/Setup/Page/Index.html#includecss-array).

Using an XClass, this extension forces the integration of all 
specified CSS files as inline CSS and also considers external CSS files.

Currently, this feature cannot yet be deactivated via TypoScript.

## 1.5 Extended ProxyCaching with Varnish
This extension allows an extended setup with Varnish. 
By default pages are excluded from Varnish caching if a frontend cookie is set. This is to prevent personal data from being cached and thus becoming visible to strangers. 

Conversely, however, this means that Varnish caching is completely disabled for logged-in front-end users, so that they can no longer benefit from the performance improvement provided by Varnish for the entire page. To avoid this, this extension provides a field "Allow Proxy-Caching" in the page properties in the backend. This has the following options:
* **Inherit**: Inherits the settings from the page rootline
* **Deactivate**: Completely deactivates the ProxyCache for this page (and its subpages if applicable). This setting is useful e.g. for time-controlled plugins on the page
* **Activate**: Enables the ProxyCache explicitly even if a frontend cookie is set. This allows pages to be served from the Varnish cache even if a user is logged in. This should only be activated for pages that do not contain personal data.

This setup only works if the appropriate settings are made in the Varnish configuration. 
Since Varnish configurations are very individual, only the relevant lines that control the behavior of the Varnish according to the above specifications are listed here.
The following configuration example assumes that ```rkw/rkw-basics``` is used together with ```opsone-ch/varnish```.

```
#========================================================
# Sub-routine when request is received
#========================================================
sub vcl_recv {

[...]

    # Catch BAN Command for TYPO3 extension "Varnish"
    # This bans specific cache objects from cache
    if (req.method == "BAN" && client.ip ~ ban) {
    
        if(req.http.Varnish-Ban-All == "1" && req.http.Varnish-Ban-TYPO3-Sitename) {
            ban("req.url ~ /" + " && obj.http.TYPO3-Sitename == " + req.http.Varnish-Ban-TYPO3-Sitename);
            return (synth(200, "Banned all on site "+ req.http.Varnish-Ban-TYPO3-Sitename)) ;
            #===
        } else if(req.http.Varnish-Ban-All == "1") {
            ban("req.url ~ /");
            return (synth(200, "Banned all"));
            #===
        }
    
        if(req.http.Varnish-Ban-TYPO3-Pid && req.http.Varnish-Ban-TYPO3-Sitename) {
            ban("obj.http.TYPO3-Pid == " + req.http.Varnish-Ban-TYPO3-Pid + " && obj.http.TYPO3-Sitename == " + req.http.Varnish-Ban-TYPO3-Sitename);
            return (synth(202, "Banned TYPO3 pid " + req.http.Varnish-Ban-TYPO3-Pid + " on site " + req.http.Varnish-Ban-TYPO3-Sitename));
            #===
        } else if(req.http.Varnish-Ban-TYPO3-Pid) {
            ban("obj.http.TYPO3-Pid == " + req.http.Varnish-Ban-TYPO3-Pid);
            return (synth(200, "Banned TYPO3 pid "+ req.http.Varnish-Ban-TYPO3-Pid)) ;
            #===
        }
    }

    # Do purge as ban for current page
    if (req.method == "PURGE" && client.ip ~ purge) {
	    ban("req.http.host == " + req.http.host + " && req.url == " + req.url);
	    return(synth(200,"Purged"));
	    #===
    }


[...]

    # Removes all cookies named __utm? (utma, utmb...) and __unam - tracking thing. This would prevent caching
    set req.http.Cookie = regsuball(req.http.Cookie, "(^|(?<=; )) *__utm.=[^;]+;? *", "\1"); # Google Analytics
    set req.http.Cookie = regsuball(req.http.Cookie, "(^|(?<=; )) *__unam=[^;]+;? *", "\1"); # Google Analytics
    set req.http.Cookie = regsuball(req.http.Cookie, "(^|(?<=; )) *_et_coid=[^;]+;? *", "\1"); # eTracker 
    set req.http.Cookie = regsuball(req.http.Cookie, "(^|(?<=; )) *isSdEnabled=[^;]+;? *", "\1"); # perso-net shit
    set req.http.Cookie = regsuball(req.http.Cookie, "(^|(?<=; )) *cookie_optin=[^;]+;? *", "\1"); # Cookie-Opt-In
    if (req.http.Cookie == "") {
	    unset req.http.Cookie;
    }


[...]

    # do not cache TYPO3 BE User requests
    if (req.http.Cookie ~ "be_typo_user" || req.url ~ "^/typo3/") {
	    return (pass);
	    #===
    }

[...]

    # do not cache non-cached pages or specific page types and params
    # We also ignore some RealUrl-coded params from extensions
    if (
	(req.url ~ "/nc/?")
	|| (req.url ~ "/gitpull.php")
	|| (req.url ~ "(\?|&)type=")
	|| (req.url ~ "(\?|&)typeNum=")
	|| (req.url ~ "(\?|&)no_cache=1")
	|| (req.url ~ "(\?|&)no_varnish=1")
	|| (req.url ~ "(\?|&)eID=")
	|| (req.url ~ "(\?|&)cHash=")
	|| (req.url ~ "/tx-[a-z-]+/")
	|| (req.url ~ "/pagetype-[a-z-]+/")
	|| (req.url ~ "/phpmyadmin/")
    ) {
	    return (pass);
	    #===
    }

[...]

}

#========================================================
# Sub-routine after data from backend is received and before it is cached
#========================================================
sub vcl_backend_response {

[...]

    # Check for some things in header that indicate that we should not cache
    # e.g. we do NOT cache contents that are generated by users with cookies!!!
    if (
        (beresp.http.Set-Cookie)
        || (beresp.http.Vary == "*")
        || (beresp.http.Authorization)
        || (beresp.http.Pragma ~ "nocache")
        || (beresp.http.Cache-Control ~ "no-cache")
        || (beresp.http.X-TYPO3-ProxyCaching ~ "2")

        # TYPO3 uses "private" when INT-Scripts are used!
        # so we check for ProxyCaching variable in addition
        || (
            (beresp.http.Cache-Control ~ "private")
            && (! beresp.http.X-TYPO3-ProxyCaching ~ "1")
        )
    ) {

        # Do not cache this object and keep decision for the next 2 minutes
        set beresp.uncacheable = true;
        set beresp.ttl = 120s;
        return (deliver);
        #===
    }

[...]

}

#========================================================
# Sub-routine after object is loaded from cache
#========================================================
sub vcl_hit {

[...]
    # Based on the already cached object we check if there is login sensitive data allowed on the cached pages
    # If so, we pass to backend if a cookie is set
    if (
        (! obj.http.X-TYPO3-ProxyCaching ~ "1")
        && (req.http.Cookie ~ "(.fe_typo_user|PHPSESSID)")
    ) {
	    return (pass);
	    #===
    }

[...]

}

#========================================================
# Sub-routine before delivering final data
#========================================================
sub vcl_deliver {

[...]

    # Remove cache control if it isn't needed
    if (resp.http.X-TYPO3-ProxyCaching ~ "1") {
	    unset resp.http.cache-control;
    }

    # related to Varnish-Extension and RKW Basics
    unset resp.http.TYPO3-Pid;
    unset resp.http.TYPO3-Sitename;
    unset resp.http.X-TYPO3-ProxyCaching;

[...]
}

```

# 4. Breaking Changes 
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



