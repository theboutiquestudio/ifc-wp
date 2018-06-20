<?php

class IFC_ACF {
	public static function getCamposPadrao(){
		return array(
			'permalink', 'the_content', 'excerpt', 'custom_fields', 'discussion',
			'comments', 'revisions', 'slug', 'author', 'format', 'featured_image',
			'categories', 'tags', 'send-trackbacks'
		);
	}
}
