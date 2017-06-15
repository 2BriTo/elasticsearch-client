<?php

namespace Test\Unit\Novaway\ElasticsearchClient\Query;

use atoum\test;

class Result extends test
{
    public function testCreateFromArray()
    {
        $elasticResultData = [
            'timed_out' => false,
            'took' => 62,
            '_shards' => [
                'total' => 1,
                'successful' => 1,
                'failed' => 0
            ],
            'hits' => [
                'total' => 2,
                'max_score' => 1.3862944,
                'hits' => [
                    [
                        '_index' => 'twitter',
                        '_type' => 'tweet',
                        '_id' => '0',
                        '_score' => 1.3862944,
                        '_source' => [
                            'user' => 'skwi',
                            'date' => '2016-11-15T14:12:12',
                            'message' => 'trying out Elasticsearch',
                            'likes' => 0
                        ]
                    ],
                    [
                        '_index' => 'twitter',
                        '_type' => 'tweet',
                        '_id' => '0',
                        '_score' => 1.3862944,
                        '_source' => [
                            'user' => 'ced',
                            'date' => '2016-12-02T11:24:36',
                            'message' => 'testing php client',
                            'likes' => 4
                        ]
                    ]
                ]
            ]
        ];

        $this
            ->given($class = $this->testedClass->getClass())
            ->if($result = $class::createFromArray($elasticResultData))
            ->then
            ->integer($result->totalHits())
                ->isEqualTo(2)
            ->array($result->hits())->size->isEqualTo(2)
            ->array($result->hits())->array[1]->string['user']->isEqualTo('ced')
            ->array($result->hits())->array[1]->string['date']->isEqualTo('2016-12-02T11:24:36')
            ->array($result->hits())->array[1]->string['message']->isEqualTo('testing php client')
            ->array($result->hits())->array[1]->integer['likes']->isEqualTo(4)
        ;

    }


}
