<?php
/**
 * Created by PhpStorm.
 * User: yuriy
 * Date: 11/14/17
 * Time: 4:52 PM
 */

namespace Service;


use config\Constants;
use lib\DirectoryHelper;
use lib\Request;
use mvc\Service\ImageService;
use mvc\Service\RepositoryManager;
use mvc\Service\Session;
use mvc\Service\UserAuthService;

/**
 * Class ServiceProvider
 * @package Service
 */
class ServiceProvider
{
    /**
     * @var Validator
     */
    private $validator;
    /**
     * @var ClientScript
     */
    private $clientScript;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var RepositoryManager
     */
    private $repositoryManager;

    /**
     * @var ImageService
     */
    private $imageService;

    /**
     * @var Session
     */
    private  $session;

    /**
     * @var UserAuthService
     */
    private $userAuthService;

/*
    public function __construct(ClientScript $clientScript)
    {
        $this->clientScript = $clientScript;
    }
*/

    /**
     * @return ClientScript
     */
    public function getClientScript(): ClientScript
    {
        if (is_null($this->clientScript)) {
            $this->clientScript = new ClientScript(new DirectoryHelper(), !Constants::DEBUG_MODE);
        }

        return $this->clientScript;
    }


    /**
     * @return Validator
     */
    public function getValidator(): Validator
    {
        if (is_null($this->validator)) {
            $this->validator = new Validator();
        }

        return $this->validator;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        if (is_null($this->request)) {
            $this->request = new Request();
        }

        return $this->request;
    }

    /**
     * @return RepositoryManager
     */
    public function getRepositoryManager(): RepositoryManager
    {
        if (is_null($this->repositoryManager)) {
            $this->repositoryManager = new RepositoryManager();
        }

        return $this->repositoryManager;
    }

    /**
     * @return ImageService
     */
    public function getImageService(): ImageService
    {
        if (is_null($this->imageService)) {
            $this->imageService = new ImageService();
        }

        return $this->imageService;
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        if (is_null($this->session)) {
            $this->session = new Session();
        }
        return $this->session;
    }

    /**
     * @return UserAuthService
     */
    public function getUserAuthService(): UserAuthService
    {
        if (is_null($this->userAuthService)) {
            $this->userAuthService = new UserAuthService($this->getSession());
        }
        return $this->userAuthService;
    }


}