<?php

namespace Drupal\hr_common\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Provides a 'Related Technology Block' block.
 *
 * @Block(
 *   id = "rightsideblock",
 *   admin_label = @Translation(" Right Side Block")
 * )
 */
class RightSideBlock extends BlockBase {

    /**
     * {@inheritdoc}
     *
     * The return value of the build() method is a renderable array. Returning an
     * empty array will result in empty block contents. The front end will not
     * display empty blocks.
     */
    public function build() {

        $node = \Drupal::request()->attributes->get('node');

        if (!empty($node)) {
            $node_type = $node->getType();

            if ($node_type == 'newsletter') {
                if ($node->hasField('field_right_sidebar_image')) {
                    if ($node->get('field_right_sidebar_image')) {
                        $logo_id = $node->get('field_right_sidebar_image')->getValue()['0']['target_id'];
                        $url_value = $this->get_image_url_fid($logo_id);
                        $right['logo_url'] = $url_value;
                    }
                }

                return [
                    '#theme' => 'rightsideblock',
                    '#right' => $right,
                    '#cache' => [
                        'max-age' => 0,
                    ],
                ];
            }
        }
        return [];
    }

    /**
     * Get image url from fid.
     */
    function get_image_url_fid($id) {
        $file = File::load($id);
        if ($file) {
            $uri = $file->getFileUri();
        }
        if ($uri) {
            $url = file_create_url($uri);
        }
        return $url;
    }

}
