<?php

declare(strict_types=1);

namespace OpenTelemetry\SDK\Resource\Detectors;

use function class_exists;
use Composer\InstalledVersions;
use OpenTelemetry\SDK\Attributes;
use OpenTelemetry\SDK\Resource\ResourceDetectorInterface;
use OpenTelemetry\SDK\Resource\ResourceInfo;
use OpenTelemetry\SemConv\ResourceAttributes;

final class Composer implements ResourceDetectorInterface
{
    public function getResource(): ResourceInfo
    {
        if (!class_exists(InstalledVersions::class)) {
            return ResourceInfo::emptyResource();
        }

        $attributes = [
            ResourceAttributes::SERVICE_NAME => InstalledVersions::getRootPackage()['name'],
            ResourceAttributes::SERVICE_VERSION => InstalledVersions::getRootPackage()['pretty_version'],
        ];

        return ResourceInfo::create(new Attributes($attributes), ResourceAttributes::SCHEMA_URL);
    }
}
