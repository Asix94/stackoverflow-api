<?php

namespace UnitTest\Infrastructure;

use App\Infrastructure\BigQueryRepository;
use App\Infrastructure\Exceptions\ProcessQueryException;
use Exception;
use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\JobConfigurationInterface;
use PHPUnit\Framework\TestCase;

final class BigQueryRepositoryTest extends TestCase
{
    public function testFindPopularTags(): void
    {
        $bigQueryClient = $this->getMockBuilder(BigQueryClient::class)->disableOriginalConstructor()->getMock();
        $jobConfigurationInterface = $this->getMockBuilder(JobConfigurationInterface::class)->getMock();

        $bigQueryClient->expects($this->once())->method('query')->willReturn($jobConfigurationInterface);
        $bigQueryClient->expects($this->once())->method('runQuery')->willReturn([["tag" => "python", "c" => 465274],["tag" => "python", "c" => 465274]]);

        $bigQueryRepository = new BigQueryRepository($bigQueryClient);

        $popularTags = $bigQueryRepository->findPopularTags('2022');
        $this->assertCount(2, $popularTags);
    }

    public function testThrowsExceptionWhenQueryFails(): void
    {
        $bigQueryClient = $this->getMockBuilder(BigQueryClient::class)->disableOriginalConstructor()->getMock();
        $bigQueryClient->expects($this->once())->method('query')->willThrowException(new ProcessQueryException());
        $bigQueryRepository = new BigQueryRepository($bigQueryClient);

        $this->expectException(ProcessQueryException::class);
        $bigQueryRepository->findPopularTags('2022');
    }

    public function testThrowsExceptionWhenRunQueryFails(): void
    {
        $bigQueryClient = $this->getMockBuilder(BigQueryClient::class)->disableOriginalConstructor()->getMock();
        $jobConfigurationInterface = $this->getMockBuilder(JobConfigurationInterface::class)->getMock();

        $bigQueryClient->expects($this->once())->method('query')->willReturn($jobConfigurationInterface);
        $bigQueryClient->expects($this->once())->method('runQuery')->willThrowException(new ProcessQueryException());
        $bigQueryRepository = new BigQueryRepository($bigQueryClient);

        $this->expectException(ProcessQueryException::class);
        $bigQueryRepository->findPopularTags('2022');
    }
}
