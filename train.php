<?php

include __DIR__ . '/vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\NDJSON;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\CrossValidation\Metrics\Accuracy;

echo 'Loading data into memory ...' . PHP_EOL;

$dataset = Labeled::fromIterator(new NDJSON('dataset.ndjson'));

[$training, $testing] = $dataset->stratifiedSplit(0.8);

$estimator = new KNearestNeighbors(3);

echo 'Training ...' . PHP_EOL;

$estimator->train($dataset);

echo 'Making predictions ...' . PHP_EOL;

$predictions = $estimator->predict($testing);

$metric = new Accuracy();

$score = $metric->score($predictions, $testing->labels());

echo "Accuracy is $score" . PHP_EOL;
