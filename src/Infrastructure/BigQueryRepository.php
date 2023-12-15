<?php

namespace App\Infrastructure;

use App\Domain\PopularTag;
use App\Domain\PopularTags;
use App\Domain\StackoverflowRepository;

use App\Infrastructure\Exceptions\ProcessQueryException;
use Google\Cloud\BigQuery\BigQueryClient;

use function Lambdish\Phunctional\map;

final class BigQueryRepository implements StackoverflowRepository
{
    public function __construct(private readonly BigQueryClient $bigQueryClient) {}

    public function findPopularTags(string $year): PopularTags
     {
         try {
             $queryJobConfig = $this->bigQueryClient->query(sprintf(self::POPULAR_TAGS_QUERY, $year));
             $queryJobConfig = $this->bigQueryClient->runQuery($queryJobConfig);
         } catch (\Exception) {
             throw new ProcessQueryException();
         }

        return PopularTags::create(
            $year,
            map(function (array $popularTag) {
                return PopularTag::create(
                    $popularTag['tag'],
                    $popularTag['c']
                );
            }, $queryJobConfig)
        );
     }

    public const POPULAR_TAGS_QUERY = "SELECT tag, COUNT(*) c
                    FROM (
                      SELECT SPLIT(tags, '|') tags
                      FROM `bigquery-public-data.stackoverflow.posts_questions` a
                      WHERE EXTRACT(YEAR FROM creation_date)>=%s
                    ), UNNEST(tags) tag
                    GROUP BY 1
                    ORDER BY 2 DESC
                    LIMIT 10";
}
