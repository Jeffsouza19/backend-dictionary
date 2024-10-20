<?php

namespace App\Services;

use App\Repositories\Interfaces\User\UserFavoriteInterface;
use App\Repositories\Interfaces\User\UserHistoryInterface;
use App\Repositories\Interfaces\User\UserInterface;
use Illuminate\Support\Facades\Cache;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserService
{
    protected UserInterface $repo;
    protected UserHistoryInterface $userHistory;
    protected UserFavoriteInterface $userFavorite;
    public function __construct(UserInterface $repo, UserHistoryInterface $userHistory, UserFavoriteInterface $userFavorite)
    {
        $this->repo = $repo;
        $this->userHistory = $userHistory;
        $this->userFavorite = $userFavorite;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getHistory(): array
    {
        $cachedHistory = Cache::get('history');
        if ($cachedHistory) {
            $cachedHistory['cache'] = true;
            return $cachedHistory;
        }

        $limit = request()->get('limit', 10);
        $user = auth()->user();

        $history = $this->userHistory->getHistory($user, $limit);
        Cache::set('history', $history, 60);
        return $history;

    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getFavorite(): array
    {
        $cachedFavorite = Cache::get('favorite');
        if ($cachedFavorite) {
            return $cachedFavorite;
        }

        $limit = request()->get('limit', 10);
        $user = auth()->user();

        $favorite =  $this->userFavorite->getFavorite($user, $limit);
        Cache::set('favorite', $favorite, 60);
        return $favorite;
    }
}
