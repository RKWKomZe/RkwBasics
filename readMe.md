# rkw_basics
## 1. Features
__Detailed description coming soon...__

# 2. Breaking Changes
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

# 3. Update to v9.5
* Execute this via database BEFORE doing any updates on the database:
```
RENAME TABLE `tx_rkwbasics_domain_model_mediasources` TO `tx_coreextended_domain_model_mediasources`;
```
* Execute this via database BEFORE removing unused fields:
```
UPDATE pages SET tx_accelerator_proxy_caching = tx_rkwbasics_proxy_caching;
UPDATE pages SET tx_coreextended_alternative_title = tx_rkwbasics_alternative_title;
UPDATE pages SET tx_coreextended_fe_layout_next_level = tx_rkwbasics_fe_layout_next_level;
UPDATE pages SET no_index = tx_rkwbasics_no_index;
UPDATE pages SET no_follow = tx_rkwbasics_no_follow;
UPDATE pages SET tx_coreextended_preview_image = tx_rkwbasics_teaser_image;
UPDATE pages SET tx_coreextended_file = tx_rkwbasics_file;
UPDATE pages SET tx_coreextended_cover = tx_rkwbasics_cover;
UPDATE pages SET tx_coreextended_images_no_copyright = tx_rkwbasics_images_no_copyright;
UPDATE sys_file_reference SET fieldname = 'txCoreextendedPreviewImage' WHERE fieldname = 'txRkwbasicsTeaserImage';
UPDATE sys_file_reference SET fieldname = 'txCoreextendedFile' WHERE fieldname = 'txRkwbasicsFile';
UPDATE sys_file_reference SET fieldname = 'txCoreextendedCover' WHERE fieldname = 'txRkwbasicsCover';
UPDATE sys_file_metadata SET tx_coreextended_source = tx_rkwbasics_source;
UPDATE sys_file_metadata SET tx_coreextended_publisher = tx_rkwbasics_publisher;
UPDATE tt_content SET list_type = "coreextended_mediasources" WHERE list_type = "rkwbasics_rkwmediasources";
```
