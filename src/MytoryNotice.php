<?php

namespace Mytory\Notice;

class MytoryNotice {
	private $postTypeLabel;
	private $postTypeKey;

	public function __construct( $postTypeLabel = '홈 이미지 위 공지', $postTypeKey = 'mytory_notice' ) {
		$this->postTypeLabel = $postTypeLabel;
		$this->postTypeKey   = $postTypeKey;
		add_action( 'init', [ $this, 'registerPostType' ] );
		add_action( 'admin_init', [ $this, 'boardCapabilities' ] );
		add_action( "save_post_{$this->postTypeKey}", [ $this, 'updateMeta' ], 10, 3 );
	}

	public function registerPostType() {
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
			'not_found'          => "등록된 {$this->postTypeLabel}가 없습니다",
			'not_found_in_trash' => "휴지통에 {$this->postTypeLabel}가 없습니다",
			'parent_item_colon'  => "부모 {$this->postTypeLabel}:",
			'menu_name'          => "{$this->postTypeLabel}",
		];

		$args = [
			'labels'        => $labels,
			'menu_position' => 40,
			'show_ui'       => true,
			'supports'      => [ 'title', 'editor' ],
			'capabilities'  => [
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
			'map_meta_cap'  => true,
		];

		register_post_type( $this->postTypeKey, $args );
	}

	public function boardCapabilities() {
		$capabilities = [
			"edit_{$this->postTypeKey}",
			"read_{$this->postTypeKey}",
			"delete_{$this->postTypeKey}",
			"delete_published_{$this->postTypeKey}" . "s", // s가 눈에 안 띌까봐 일부러 이렇게 씀.
			"edit_{$this->postTypeKey}" . "s", // s가 눈에 안 띌까봐 일부러 이렇게 씀.
			"edit_published_{$this->postTypeKey}" . "s", // s가 눈에 안 띌까봐 일부러 이렇게 씀.
			"edit_other_{$this->postTypeKey}",
			"publish_{$this->postTypeKey}",
			"read_private_{$this->postTypeKey}",
		];

		$roles = [ 'administrator', 'editor' ];

		foreach ( $roles as $role ) {
			$wp_role = get_role( $role );
			foreach ( $capabilities as $capability ) {
				$wp_role->add_cap( $capability );
			}
		}
	}

	/**
	 * <code><input name="meta[_mytory_board_custom_key]"></code>로 값을 넘기면 postmeta에 저장한다.
	 * <code>mytory_board</code>는 당연히 <code>$taxonomyKey</code>로 대체해야 한다.
	 *
	 * @param          $post_id
	 * @param \WP_Post $post
	 * @param          $is_update
	 */
	function updateMeta( $post_id, \WP_Post $post, $is_update ) {
		if ( ! empty( $_POST['meta'] ) ) {
			foreach ( $_POST['meta'] as $k => $v ) {
				if ( strpos( $k, "_{$this->taxonomyKey}_" ) === 0 ) {
					update_post_meta( $post_id, $k, $v );
				}
			}
		}
	}
}