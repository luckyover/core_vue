<?php

namespace App\api\Common\Models\App;

use AnsModel;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="AppState",
 *      description="Current state of one application session"
 * )
 */
class AppState extends AnsModel
{
    public function __construct()
    {
        $this->profile = new Profile;
        $this->menus = collect();
        $this->functions = collect();
        $this->sys_msgs = collect();
    }

    /**
     * @OA\Property(ref="#/components/schemas/Profile")
     */
    public Profile $profile;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/Menu")
     * )
     */
    public Collection $menus;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/SystemFunction")
     * )
     */
    public Collection $functions;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/ErrorMessage")
     * )
     */
    public Collection $sys_msgs;

    public function setMenus(array $input)
    {
        $this->menus = collect();

        foreach ($input as $key => $val) {
            $this->menus->push(new Menu($val));
        }
    }

    public function setFunctions(array $input)
    {
        $this->functions = collect();

        foreach ($input as $key => $val) {
            $this->functions->push(new SystemFunction($val));
        }
    }

    public function setMessages(array $input)
    {
        $this->sys_msgs = collect();

        foreach ($input as $key => $val) {
            $this->sys_msgs->push(new ErrorMessage($val));
        }
    }
}
