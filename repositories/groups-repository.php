<?php

/**
 * Fetch data related to DT groups
 * Class DT_33_Groups_Repository
 */
class DT_33_Groups_Repository
{
    private static $_instance = null;

    public $meetings = null;

    private function args()
    {
        return [
            'sort' => 'name'
        ];
    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $this->meetings = DT_33_Meetings_Repository::instance();
    }

    public function all()
    {
        return DT_Posts::list_posts('groups', $this->args())['posts'];
    }

    /**
     * Search meetings
     * @param $search
     * @return array|WP_Error|WP_Query
     */
    public function search($search)
    {
        return DT_Posts::get_viewable_compact('groups', $search, $this->args());
    }

    /**
     * Extract the groups that have meetings
     * @param array $params
     * @return array
     */
    public function with_meetings($params = [])
    {
        $groups = array_values(array_reduce($this->meetings->all($params), function ($groups, $meeting) {
            if (!$meeting['groups'] || !count($meeting['groups'])) {
                return $groups;
            }

            foreach ($meeting['groups'] as $group) {
                $groups[$group['ID']] = $group;
            }

            return $groups;
        }, []));

        //ABC order
        usort($groups, function ($a, $b) {
            return strcmp($a["post_title"], $b["post_title"]);
        });

        return $groups;
    }

    public function create($params)
    {
        return DT_Posts::create_post('groups', $params, false, false);
    }

    /**
     * Find by ID
     */
    public function find($id)
    {
        $filtered = array_filter($this->all(), function ($group) use ($id) {
            return (int) $group['ID'] === (int) $id;
        });
        if (count($filtered)) {
            return array_values($filtered)[0];
        }
        return null;
    }

    /**
     * Find by title
     */
    public function find_by_title($title)
    {
        $post = get_page_by_title($title, OBJECT, 'groups');

        if (!$post) {
            return $post;
        }

        return $this->find($post->ID);
    }

    /**
     * Get members contacts attached to a single group*
     * @param $group_id
     * @return array    
     */

    public function members($group_id)
    {
        $group = DT_Posts::get_post('groups', $group_id, true, false);

        if (is_wp_error($group) || !$group) {
            return [];
        }

        return $group['members'] ?? [];
    }

    /**
     * Get the deduplicated members across one or more groups, optionally filtered by a search text.
     * @param array|int $group_ids
     * @param string|null $search
     * @return array
     */
    public function search_members($group_ids, $search = null)
    {
        $group_ids = is_array($group_ids) ? $group_ids : [$group_ids];
        $members = [];

        foreach ($group_ids as $group_id) {
            foreach ($this->members($group_id) as $member) {
                $members[$member['ID']] = $member;
            }
        }

        if ($search) {
            $members = array_filter($members, function ($member) use ($search) {
                return stripos($member['post_title'] ?? '', $search) !== false;
            });
        }

        return array_values($members);
    }


}
