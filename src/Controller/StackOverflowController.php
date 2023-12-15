<?php

namespace App\Controller;

use App\Application\PopularTagsResponse;
use App\Domain\StackoverflowRepository;
use App\Infrastructure\Exceptions\ProcessQueryException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class StackOverflowController extends AbstractController
{
    private StackoverflowRepository $stackoverflowRepository;
    private PopularTagsResponse     $popularTagsResponse;

    public function __construct(
        StackoverflowRepository $stackoverflowRepository,
        PopularTagsResponse $popularTagsResponse
    ) {
        $this->stackoverflowRepository = $stackoverflowRepository;
        $this->popularTagsResponse     = $popularTagsResponse;
    }

    /**
     * @Route("/stackoverflow/tags/popular", name="stackoverflow")
     */
    public function getPopularTags(Request $request): JsonResponse
    {
        $year = $request->query->get('year') ?: date('Y');
        try {
            $mostPopularTags = $this->stackoverflowRepository->findPopularTags($year);
        } catch (ProcessQueryException $e) {
            return $this->json("Error connecting to Stackoverflow");
        }
        return $this->json(['Popular tags' => $this->popularTagsResponse->popularTags($mostPopularTags)]);
    }
}
