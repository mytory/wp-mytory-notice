<?php

namespace Mytory\Notice;

class MytoryNotice
{
    private $postTypeLabel;
    private $postTypeKey;

    public function __construct($postTypeLabel = '메인 이미지 위 공지', $postTypeKey = 'mytory_notice')
    {
        $this->postTypeLabel = $postTypeLabel;
        $this->postTypeKey = $postTypeKey;
        add_action( 'init', [ $this, 'registerPostType' ] );
    }

    public function registerPostType()
    {
        $labels = [
            'name'               => "{$this->postTypeLabel}",
            'singular_name'      => "{$this->postTypeLabel}",
            'add_new'            => "{$this->postTypeLabel} 추가",
            'add_new_item'       => "{$this->postTypeLabel} 추가",
            'edit_item'          => "{$this->postTypeLabel} 수정",
            'new_item'           => "{$this->postTypeLabel} 추가",
            'all_items'          => "{$this->postTypeLabel}",
            'view_item'          => "{$this->postTypeLabel} 상세 보기",
            'search_items'       => "{$this->postTypeLabel} 검색",
            'not_found'          => "등록된 {$this->postTypeLabel}이 없습니다",
            'not_found_in_trash' => "휴지통에 {$this->postTypeLabel}이 없습니다",
            'parent_item_colon'  => "부모 {$this->postTypeLabel}:",
            'menu_name'          => "{$this->postTypeLabel}",
        ];

        $args = [
            'labels'       => $labels,
            'show_ui'      => true,
            'supports'     => [ 'title', 'editor' ],
            'capabilities' => [
                'edit_post'              => "edit_{$this->postTypeKey}",
                'read_post'              => "read_{$this->postTypeKey}",
                'delete_post'            => "delete_{$this->postTypeKey}",
                'delete_published_posts' => "delete_published_{$this->postTypeKey}" . "s", // s가 눈에 안 띌까봐 일부러 이렇게 씀.
                'edit_posts'             => "edit_{$this->postTypeKey}" . "s", // s가 눈에 안 띌까봐 일부러 이렇게 씀.
                'edit_published_posts'   => "edit_published_{$this->postTypeKey}" . "s", // s가 눈에 안 띌까봐 일부러 이렇게 씀.
                'edit_others_posts'      => "edit_other_{$this->postTypeKey}",
                'publish_posts'          => "publish_{$this->postTypeKey}",
                'read_private_posts'     => "read_private_{$this->postTypeKey}",
            ],
            'map_meta_cap' => true,
        ];

        register_post_type( $this->postTypeKey, $args );
    }
}