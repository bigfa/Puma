<?php

class pumaSetting
{
    public $config;

    function __construct($config = [])
    {
        $this->config = $config;
        add_action('admin_menu', [$this, 'setting_menu']);
        add_action('admin_enqueue_scripts', [$this, 'setting_scripts']);
        add_action('wp_ajax_puma_setting', array($this, 'setting_callback'));
        //add_action('wp_ajax_nopriv_Puma_setting', array($this, 'setting_callback'));
    }

    function clean_options(&$value)
    {
        $value = stripslashes($value);
    }

    function setting_callback()
    {
        $data = $_POST[PUMA_SETTING_KEY];
        array_walk_recursive($data,  array($this, 'clean_options'));
        $this->update_setting($data);
        return wp_send_json([
            'code' => 200,
            'message' => __('Success', 'Puma'),
            'data' => $this->get_setting()
        ]);
    }

    function setting_scripts()
    {
        if (isset($_GET['page']) && $_GET['page'] == 'puma') {
            wp_enqueue_style('puma-setting', get_template_directory_uri() . '/build/css/setting.min.css', array(), PUMA_VERSION, 'all');
            wp_enqueue_script('puma-setting', get_template_directory_uri() . '/build/js/setting.min.js', ['jquery'], PUMA_VERSION, true);
            wp_localize_script(
                'puma-setting',
                'obvInit',
                [
                    'is_single' => is_singular(),
                    'post_id' => get_the_ID(),
                    'restfulBase' => esc_url_raw(rest_url()),
                    'nonce' => wp_create_nonce('wp_rest'),
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'success_message' => __('Setting saved success!', 'Puma'),
                    'upload_title' => __('Upload Image', 'Puma'),
                ]
            );
        }
    }

    function setting_menu()
    {
        add_menu_page(__('Theme Setting', 'Puma'), __('Theme Setting', 'Puma'), 'manage_options', 'puma', [$this, 'setting_page'], '', 59);
    }

    function setting_page()
    { ?>
        <div class="wrap">
            <h2><?php _e('Theme Setting', 'Puma') ?>
                <a href="https://docs.wpista.com/" target="_blank" class="page-title-action"><?php _e('Documentation', 'Puma') ?></a>
            </h2>
            <div class="pure-wrap">
                <div class="leftpanel">
                    <ul class="nav">
                        <?php foreach ($this->config['header'] as $val) {
                            $id = $val['id'];
                            $title = __($val['title'], 'Puma');
                            $icon = $val['icon'];
                            $class = ($id == "basic") ? "active" : "";
                            echo "<li class=\"$class\"><span id=\"tab-title-$id\"><i class=\"dashicons-before dashicons-$icon\"></i>$title</span></li>";
                        } ?>
                    </ul>
                </div>
                <form id="pure-form" method="POST" action="options.php">
                    <?php
                    foreach ($this->config['body'] as $val) {
                        $id = $val['id'];
                        $class = $id == "basic" ? "div-tab" : "div-tab hidden";
                    ?>
                        <div id="tab-<?php echo $id; ?>" class="<?php echo $class; ?>">
                            <?php if (isset($val['docs'])) : ?>
                                <div class="pure-docs">
                                    <a href="<?php echo $val['docs']; ?>" target="_blank"><?php _e('Documentation', 'Puma') ?></a>
                                </div>
                            <?php endif; ?>
                            <table class="form-table">
                                <tbody>
                                    <?php
                                    $content = $val['content'];
                                    foreach ($content as $k => $row) {
                                        switch ($row['type']) {
                                            case 'textarea':
                                                $this->setting_textarea($row);
                                                break;

                                            case 'switch':
                                                $this->setting_switch($row);
                                                break;

                                            case 'input':
                                                $this->setting_input($row);
                                                break;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    <div class="pure-save"><span id="pure-save" class="button--save"><?php _e('Save', 'Puma') ?></span></div>
                </form>
            </div>
        </div>
    <?php }

    function get_setting($key = null)
    {
        $setting = get_option(PUMA_SETTING_KEY);

        if (!$setting) {
            return false;
        }

        if ($key) {
            if (array_key_exists($key, $setting)) {
                return $setting[$key];
            } else {
                return false;
            }
        } else {
            return $setting;
        }
    }

    function update_setting($setting)
    {
        update_option(PUMA_SETTING_KEY, $setting);
    }

    function empty_setting()
    {
        delete_option(PUMA_SETTING_KEY);
    }

    function setting_input($params)
    {
        $default = $this->get_setting($params['name']);
    ?>
        <tr>
            <th scope="row">
                <label for="pure-setting-<?php echo $params['name']; ?>"><?php echo __($params['label'], 'Puma'); ?></label>
            </th>
            <td>
                <input type="text" id="pure-setting-<?php echo $params['name']; ?>" name="<?php printf('%s[%s]', PUMA_SETTING_KEY, $params['name']); ?>" value="<?php echo $default; ?>" class="regular-text">
                <?php printf('<br /><br />%s', __($params['description'], 'Puma')); ?>
            </td>
        </tr>
    <?php }

    function setting_textarea($params)
    { ?>
        <tr>
            <th scope="row">
                <label for="pure-setting-<?php echo $params['name']; ?>"><?php echo __($params['label'], 'Puma'); ?></label>
            </th>
            <td>
                <textarea name="<?php printf('%s[%s]', PUMA_SETTING_KEY, $params['name']); ?>" id="pure-setting-<?php echo $params['name']; ?>" class="large-text code" rows="5" cols="50"><?php echo $this->get_setting($params['name']); ?></textarea>
                <?php printf('<br />%s', __($params['description'], 'Puma')); ?>
            </td>
        </tr>
    <?php }

    function setting_switch($params)
    {
        $val = $this->get_setting($params['name']);
        $val = $val ? 1 : 0;
    ?>
        <tr>
            <th scope="row">
                <label for="pure-setting-<?php echo $params['name']; ?>"><?php echo __($params['label'], 'Puma'); ?></label>
            </th>
            <td>
                <a class="pure-setting-switch<?php if ($val) echo ' active'; ?>" href="javascript:;" data-id="pure-setting-<?php echo $params['name']; ?>">
                    <i></i>
                </a>
                <br />
                <input type="hidden" id="pure-setting-<?php echo $params['name']; ?>" name="<?php printf('%s[%s]', PUMA_SETTING_KEY, $params['name']); ?>" value="<?php echo $val; ?>" class="regular-text">
                <?php printf('<br />%s', __($params['description'], 'Puma')); ?>
            </td>
        </tr>
<?php }
}
global $pumaSetting;
$pumaSetting = new pumaSetting(
    [
        "header" => [
            [
                'id' => 'basic',
                'title' => __('Basic Setting', 'Puma'),
                'icon' => 'basic'
            ],
            [
                'id' => 'feature',
                'title' => __('Feature Setting', 'Puma'),
                'icon' => 'slider'

            ],
            [
                'id' => 'singluar',
                'title' => __('Singluar Setting', 'Puma'),
                'icon' => 'feature'
            ],
            [
                'id' => 'meta',
                'title' => __('SNS Setting', 'Puma'),
                'icon' => 'social-contact'
            ],
            [
                'id' => 'custom',
                'title' => __('Custom Setting', 'Puma'),
                'icon' => 'interface'
            ]
        ],
        "body" => [
            [
                'id' => 'basic',
                'content' => [
                    [
                        'type' => 'textarea',
                        'name' => 'description',
                        'label' => __('Description', 'Puma'),
                        'description' => __('Site description', 'Puma'),
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'headcode',
                        'label' => __('Headcode', 'Puma'),
                        'description' => __('You can add content to the head tag, such as site verification tags, and so on.', 'Puma'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'banner',
                        'label' => __('Banner', 'Puma'),
                        'description' => __('Header banner address.', 'Puma'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'og_default_thumb',
                        'label' => __('Og default thumb', 'Puma'),
                        'description' => __('Og meta default thumb address.', 'Puma'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'favicon',
                        'label' => __('Favicon', 'Puma'),
                        'description' => __('Favicon address', 'Puma'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'title_sep',
                        'label' => __('Title sep', 'Puma'),
                        'description' => __('Default is', 'Puma') . '<code>-</code>',
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'disable_block_css',
                        'label' => __('Disable block css', 'Puma'),
                        'description' => __('Do not load block-style files.', 'Puma')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'gravatar_proxy',
                        'label' => __('Gravatar proxy', 'Puma'),
                        'description' => __('Gravatar proxy domain,like <code>cravatar.cn</code>', 'Puma'),
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'rss_tag',
                        'label' => __('RSS Tag', 'Puma'),
                        'description' => __('You can add tag in rss to verify follow.', 'Puma'),
                    ],
                ]
            ],
            [
                'id' => 'feature',
                'docs' => 'https://docs.wpista.com/config/feature.html',
                'content' => [
                    [
                        'type' => 'switch',
                        'name' => 'auto_update',
                        'label' => __('Update notice', 'Puma'),
                        'description' => __('Get theme update notice.', 'Puma')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'upyun',
                        'label' => __('Upyun CDN', 'Puma'),
                        'description' => __('Make sure all images are uploaded to Upyun, otherwise thumbnails may not display properly.', 'Puma')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'oss',
                        'label' => __('Aliyun OSS CDN', 'Puma'),
                        'description' => __('Make sure all images are uploaded to Aliyun OSS, otherwise thumbnails may not display properly.', 'Puma')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'qiniu',
                        'label' => __('Qiniu OSS CDN', 'Puma'),
                        'description' => __('Make sure all images are uploaded to Qiniu OSS, otherwise thumbnails may not display properly.', 'Puma')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'darkmode',
                        'label' => __('Dark Mode', 'Puma'),
                        'description' => __('Enable dark mode', 'Puma')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'default_thumbnail',
                        'label' => __('Default thumbnail', 'Puma'),
                        'description' => __('Default thumbnail address', 'Puma')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'back2top',
                        'label' => __('Back to top', 'Puma'),
                        'description' => __('Enable back to top', 'Puma')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'loadmore',
                    //     'label' => __('Load more', 'Puma'),
                    //     'description' => __('Enable load more', 'Puma')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'home_author',
                    //     'label' => __('Author info', 'Puma'),
                    //     'description' => __('Enable author info in homepage', 'Puma')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'home_cat',
                    //     'label' => __('Category info', 'Puma'),
                    //     'description' => __('Enable category info in homepage', 'Puma')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'home_like',
                    //     'label' => __('Like info', 'Puma'),
                    //     'description' => __('Enable like info in homepage', 'Puma')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'home_image_count',
                    //     'label' => __('Image count', 'Puma'),
                    //     'description' => __('Show image count of the post', 'Puma')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'hide_home_cover',
                        'label' => __('Hide home cover', 'Puma'),
                        'description' => __('Hide home cover', 'Puma')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'exclude_status',
                        'label' => __('Exclude status', 'Puma'),
                        'description' => __('Exclude post type status in homepage', 'Puma')
                    ],
                ]
            ],

            [
                'id' => 'singluar',
                'content' => [
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'bio',
                    //     'label' => __('Author bio', 'Puma'),
                    //     'description' => __('Enable author bio', 'Puma')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'author_sns',
                    //     'label' => __('Author sns icons', 'Puma'),
                    //     'description' => __('Show author sns icons, will not show when author bio is off.', 'Puma')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'related',
                        'label' => __('Related posts', 'Puma'),
                        'description' => __('Enable related posts', 'Puma')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'postlike',
                        'label' => __('Post like', 'Puma'),
                        'description' => __('Enable post like', 'Puma')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'post_navigation',
                        'label' => __('Post navigation', 'Puma'),
                        'description' => __('Enable post navigation', 'Puma')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'show_copylink',
                        'label' => __('Copy link', 'Puma'),
                        'description' => __('Enable copy link', 'Puma')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'category_card',
                    //     'label' => __('Category card', 'Puma'),
                    //     'description' => __('Show post category info after post.', 'Puma')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'show_parent',
                        'label' => __('Show parent comment', 'Puma'),
                        'description' => __('Enable show parent comment', 'Puma')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'toc',
                    //     'label' => __('Table of content', 'Puma'),
                    //     'description' => __('Enable table of content', 'Puma')
                    // ],
                    // [
                    //     'type' => 'input',
                    //     'name' => 'toc_start',
                    //     'label' => __('Start heading', 'Puma'),
                    //     'description' => __('Start heading,default h3', 'Puma')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'show_author',
                    //     'label' => __('Post Author', 'Puma'),
                    //     'description' => __('Show post author tip in comment', 'Puma')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'disable_comment_link',
                        'label' => __('Disable comment link', 'Puma'),
                        'description' => __('Disable comment author url', 'Puma')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'no_reply_text',
                        'label' => __('No reply text', 'Puma'),
                        'description' => __('Text display when no comment in current post.', 'Puma')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'friend_icon',
                        'label' => __('Friend icon', 'Puma'),
                        'description' => __('Show icon when comment author url is in blogroll.', 'Puma')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'image_zoom',
                    //     'label' => __('Post image zoom', 'Puma'),
                    //     'description' => __('Zoom image when a tag link to image url.', 'Puma')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'update_time',
                    //     'label' => __('Post update time', 'Puma'),
                    //     'description' => __('Show the last update time of post.', 'Puma')
                    // ],
                ]
            ],
            [
                'id' => 'meta',
                'docs' => 'https://docs.wpista.com/config/sns.html',
                'content' => [
                    [
                        'type' => 'switch',
                        'name' => 'footer_sns',
                        'label' => __('Footer SNS Icons', 'Puma'),
                        'description' => __('Show sns icons in footer, if this setting is on, the footer menu won\',t be displayed.', 'Puma')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'telegram',
                        'label' => __('Telegram', 'Puma'),
                        'description' => __('Telegram link', 'Puma')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'email',
                        'label' => __('Email', 'Puma'),
                        'description' => __('Your email address', 'Puma')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'instagram',
                        'label' => __('Instagram', 'Puma'),
                        'description' => __('Instagram link', 'Puma')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'twitter',
                        'label' => __('Twitter', 'Puma'),
                        'description' => __('Twitter link', 'Puma')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'rss',
                        'label' => __('RSS', 'Puma'),
                        'description' => __('RSS link', 'Puma')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'github',
                        'label' => __('Github', 'Puma'),
                        'description' => __('Github link', 'Puma')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'discord',
                        'label' => __('Discord', 'Puma'),
                        'description' => __('Discord link', 'Puma')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'mastodon',
                        'label' => __('Mastodon', 'Puma'),
                        'description' => __('Mastodon link', 'Puma')
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'custom_sns',
                        'label' => __('Custom', 'Puma'),
                        'description' => __('Custom sns link,use html.', 'Puma')
                    ],
                ]
            ],
            [
                'id' => 'custom',
                'content' => [
                    [
                        'type' => 'textarea',
                        'name' => 'css',
                        'label' => __('CSS', 'Puma'),
                        'description' => __('Custom CSS', 'Puma')
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'javascript',
                        'label' => __('Javascript', 'Puma'),
                        'description' => __('Custom Javascript', 'Puma')
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'copyright',
                        'label' => __('Copyright', 'Puma'),
                        'description' => __('Custom footer content', 'Puma')
                    ],
                ]
            ],
        ]
    ]
);
