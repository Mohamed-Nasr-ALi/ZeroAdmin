<?php
namespace App\Repositories\Eloquent;


use App\Agent;
use App\Cashback;
use App\Repositories\Interfaces\AgentInterface;
use App\Traits\UploadTrait;
use App\User;
use App\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Exception;
class AgentRepository implements AgentInterface
{
    use UploadTrait;
    // agent property on class instances
    protected $agent;
    protected $userRepository;
    protected $walletRepository;
    protected $cashBackRepository;
    // Constructor to bind agent to repo
    public function __construct(Agent $agent,UserRepository $userRepository,WalletRepository $walletRepository,CashBackRepository $cashBackRepository)
    {
        $this->agent = $agent;
        $this->userRepository = $userRepository;
        $this->walletRepository = $walletRepository;
        $this->cashBackRepository = $cashBackRepository;
    }

    // Get all instances of agent
    public function all()
    {
        return $this->agent->paginate(15);
    }

    public function createUser(array $data){
        return $this->userRepository->create($data);
    }

    public function createUserWallet($id){
        return $this->walletRepository->create(['user_id'=>$id]);
    }
    // create a new record in the database
    public function createAgentAfterAssignedToUser(array $data)
    {
        return $this->agent->create($data);
    }

    // update record in the database
    public function updateAgent(array $data, $id)
    {
        //find agent and get data
        $record = $this->agent->findOrFail($id);
        // if agent not update logo set old logo
        if ( $data['business_logo']===null ){
            unset($data['business_logo']);
        }else{
            //if agent set new logo remove old one and update
            if (isset($record->business_logo) || $record->business_logo !== "" ){
                File::delete($record->business_logo);
            }
        }
        return $record->update($data);
    }
    // update record in the database
    public function updateAgentUser(array $data, $id)
    {
        return $this->userRepository->update($data,$id);
    }

    public function updateUserAsAgent(array $data, $agent_id,$user_id,$cashback_id){
        $salt = $this->generate_salt();
        $password = $this->hash_new_password($data['password'], $salt);
        $user_data=[
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => $password,
            'salt' => $salt,
            'phone' => $data['phone']
        ];
        $agent_data=[
            'type_id' => $data['type_id'],
            'business_name' => $data['business_name'],
            'business_type' => $data['business_type'],
            'business_logo' => isset($data['business_logo']) ? $data['business_logo'] : null,
        ];
        $cashback_data=[
            'client_cashback'=>$data['client_cashback'],
            'zerocach_cashback'=>$data['zerocach_cashback']
        ];
        $this->updateAgent($agent_data,$agent_id);
        $this->updateAgentCashback($cashback_data,$cashback_id);
        return $this->updateAgentUser($user_data,$user_id);

    }
    // remove record from the database
    public function delete($id)
    {
        $record = $this->agent->findOrFail($id);
        return $record->destroy($record->id);
    }


    // show the record with the given id
    public function show($id)
    {
        return $this->agent->findOrFail($id);
    }

    public function uploadFile($file,$fileName)
    {
        // Check if a profile image has been uploaded
        if (isset($file)) {
            // Make a image name based on user name and current timestamp
            $name = Str::slug($fileName).'_'.time();
            // Define folder path
            $folder = 'agent_logos/';
            // Upload image
          return  $this->uploadOne($file, $folder, 'public', $name);

        }else{
            return response()->json(404,['error'=>'your file is not uploaded yet try again']);
        }
    }


    public function storeUserAsAgent(array $data){
        $salt = $this->generate_salt();
        $password = $this->hash_new_password($data['password'], $salt);
        $account_number = $this->randomInt();

        $user_data=[
            'account_number' => $account_number,
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => $password,
            'salt' => $salt,
            'phone' => $data['phone'],
            'pin' => $data['pin'],
            'role'=>1
        ];
        $agent_data=[
            'type_id' => $data['type_id'],
            'business_name' => $data['business_name'],
            'business_type' => $data['business_type'],
            'business_logo' => isset($data['business_logo']) ? $data['business_logo'] : null,
        ];
        $cashback_data=[
            'client_cashback'=>$data['client_cashback'],
            'zerocach_cashback'=>$data['zerocach_cashback']
        ];
        $user=$this->createUser($user_data);
        $user_wallet=$this->createUserWallet($user->id);
        $agent=array_merge($agent_data,['user_id'=>$user->id]);
        $stored_agent=$this->createAgentAfterAssignedToUser($agent);
        $cashback_for_agent=array_merge($cashback_data,['agent_id'=>$stored_agent->id]);
        return  $this->createCashbackForAgent($cashback_for_agent);
    }
    protected  function generate_salt($len = 32)
    {
        return substr(md5(uniqid(rand(), true)), 0, $len);
    }
    protected  function hash_new_password($password, $salt)
    {
        if (empty($password) && empty($salt)) {
            return FALSE;
        }
        return sha1($password . $salt);
    }
    protected function randomInt()
    {
        return random_int(10000000000001, 99999999999999);
    }

    public function createCashbackForAgent(array $cashback_data)
    {
        return $this->cashBackRepository->create($cashback_data);
    }

    public function updateAgentCashback(array $cashback_data, $cashback_id)
    {
       return $this->cashBackRepository->update($cashback_data,$cashback_id);
    }
}
