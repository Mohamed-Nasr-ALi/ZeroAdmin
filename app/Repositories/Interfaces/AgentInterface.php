<?php
namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Model as ModelAlias;

interface AgentInterface{
    public function all();
    /**
     * @param $id
     * @return ModelAlias
     */
    public function show($id);
    public function updateAgent(array $data, $id);
    public function updateAgentUser(array $data, $id);
    public function updateUserAsAgent(array $data, $agent_id,$user_id,$cashback_id);
    public function delete($id);
    public function uploadFile($file,$fileName);
//    /**
//     * @param array $attributes
//     * @return ModelAlias
//     */
//    public function createAgentUser(array $attributes);
    /**
     * @param array $attributes
     * @return ModelAlias
     */
    public function createUserWallet($id);
    public function createAgentAfterAssignedToUser(array $data);
    public function storeUserAsAgent(array $data);

}
