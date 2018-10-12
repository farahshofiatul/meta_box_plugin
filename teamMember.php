<?php
/*
Plugin Name: Team-Member-1
Description: Declares a plugin that will create a custom post type displaying team member.
Version: 1.0
Author: Farah Shofiatul
License: GPLv2
*/

class TeamMember1{  
    public function __construct(){
        add_action( 'init', array($this, 'create_team_member'));
        add_filter( 'rwmb_meta_boxes', array($this, 'your_prefix_get_meta_box' ));
        add_shortcode('shortcode_members_1', array($this, 'display_team_member'));
    }
    function create_team_member(){
        register_post_type( 'team_member',
        array(
            'labels' => array(
                'name' => 'Team Members',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Team Member',
                'edit' => 'Edit',
                'edit_item' => 'Edit Member',
                'new_item' => 'New Team Member',
                'view' => 'View',
                'view_item' => 'View Team Member',
                'search_items' => 'Search Team Member',
                'not_found' => 'No Team Member found',
                'not_found_in_trash' => 'No Team member found in Trash',
                'parent' => 'Parent Team Member'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            'menu_icon' => '',
            'has_archive' => true
            )
        );  
    }
function your_prefix_get_meta_box( $meta_boxes ) {
    $prefix = 'prefix-';
    $meta_boxes[] = array(
        'id' => 'team_member',
        'title' => esc_html__( 'Other Information', 'metabox-online-generator' ),
        'post_types' => 'team_member',
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => 'true',
        'fields' => array(
            array(
                'id' => $prefix . 'position',
                'type' => 'text',
                'name' => esc_html__( 'Position', 'metabox-online-generator' ),
            ),
            array(
                'id' => $prefix . 'email',
                'name' => esc_html__( 'Email', 'metabox-online-generator' ),
                'type' => 'email',
            ),
            array(
                'id' => $prefix . 'phone',
                'type' => 'text',
                'name' => esc_html__( 'Phone', 'metabox-online-generator' ),
            ),
            array(
                'id' => $prefix . 'website',
                'type' => 'text',
                'name' => esc_html__( 'Website', 'metabox-online-generator' ),
            ),
            array(
                'id' => $prefix . 'image',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Image', 'metabox-online-generator' ),
            ),
        ),
    );
    return $meta_boxes;
}
function display_team_member($atts){
        $mypost = array( 'post_type' => 'team_member' );
        $loop = new WP_Query( $mypost );
        $attr = shortcode_atts( array(
            'email' => $atts['email'],
            'phone' => $atts['phone'],
            'website' => $atts['website']
        ), $atts );
        echo '<table>';
        echo '<tr>';
        while ( $loop->have_posts() ) : 
            $loop->the_post();  
            $meta = rwmb_meta( 'prefix-image', '' ,get_the_ID() );
            echo '<td>';
            echo '<center>';
            foreach ($meta as $value) {
                 echo '<img src= "'.$value['url'].'"></br>';
            }
            echo esc_html( get_post_meta( get_the_ID(), 'prefix-position', true )).'</br>';
            if($attr['email']){
                echo esc_html( get_post_meta( get_the_ID(), 'prefix-email', true )).'</br>';
            }
            else if($attr['phone']){
                echo esc_html( get_post_meta( get_the_ID(), 'prefix-phone', true )).'</br>';
            }
            else if($attr['website']){
                echo esc_html( get_post_meta( get_the_ID(), 'prefix-website', true )).'</br>';
            }
            echo '</center>';
            echo '</td>';
        endwhile;
        echo '</tr>';
        echo '</table>';
    }
}

new TeamMember1();
?>