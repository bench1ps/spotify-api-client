<?php

namespace Bench1ps\Spotify\Session;

use Bench1ps\Spotify\Exception\SessionException;

class SessionHandler
{
    /**
     * @var Session[]
     */
    private $sessions;

    /**
     * @var Session
     */
    private $currentSession;

    /**
     * @param string $sessionId
     *
     * @throws SessionException
     */
    public function switchSession($sessionId)
    {
        if (empty($this->sessions[$sessionId])) {
            throw new SessionException(sprintf("Session %s is not being handled.", $sessionId));
        }

        $this->currentSession = $this->sessions[$sessionId];
    }

    /**
     * @param Session $session
     *
     * @throws SessionException
     */
    public function addSession(Session $session)
    {
        $sessionId = $session->getSessionId();
        if (!empty($this->sessions[$sessionId])) {
            throw new SessionException(sprintf("Session %s is already handled.", $session->getSessionId()));
        }

        $this->sessions[$sessionId] = $session;

        if (empty($this->currentSession)) {
            $this->switchSession($sessionId);
        }
    }

    /**
     * @return Session
     */
    public function getCurrentSession()
    {
        return $this->currentSession;
    }

    /**
     * @return bool
     */
    public function isHandlingSession()
    {
        return null !== $this->currentSession;
    }
}