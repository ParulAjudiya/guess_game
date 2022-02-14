<?php

namespace App\Entities;

class GameParameters
{
    private $player_name = '';
    private $requestData = [];
    private $game_session_id = '';
    private $token = '';
    private $host = 0;
    private $player_id = 0;

    /**
     * @return int
     */
    public function getPlayerId(): int
    {
        return $this->player_id;
    }

    /**
     * @param int $player_id
     */
    public function setPlayerId(int $player_id): void
    {
        $this->player_id = $player_id;
    }

    /**
     * @return int
     */
    public function getHost(): int
    {
        return $this->host;
    }

    /**
     * @param int $host
     */
    public function setHost(int $host): void
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getGameSessionId(): string
    {
        return $this->game_session_id;
    }

    /**
     * @param string $game_session_id
     */
    public function setGameSessionId(string $game_session_id): void
    {
        $this->game_session_id = $game_session_id;
    }
    /**
     * @return string
     */
    public function getPlayerName(): string
    {
        return $this->player_name;
    }

    /**
     * @param string $player_name
     */
    public function setPlayerName(string $player_name): void
    {
        $this->player_name = $player_name;
    }

    /**
     * @return array
     */
    public function getRequestData(): array
    {
        return $this->requestData;
    }

    /**
     * @param array $requestData
     */
    public function setRequestData(array $requestData): void
    {
        $this->requestData = $requestData;
    }
}
