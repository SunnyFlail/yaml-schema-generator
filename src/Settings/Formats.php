<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

enum Formats: string
{
    case DATE_TIME = 'date-time';
    case TIME = 'time';
    case DATE = 'date';
    case DURATION = 'duration';
    case EMAIL = 'email';
    case IDN_EMAIL = 'idn-email';
    case HOSTNAME = 'hostname';
    case IDN_HOSTNAME = 'idn-hostname';
    case IPV4 = 'ipv4';
    case IPV6 = 'ipv6';
    case UUID = 'uuid';
    case URI = 'uri';
    case URI_REFERENCE = 'uri-reference';
    case IRI = 'iri';
    case IRI_REFERENCE = 'iri-reference';
    case URI_TEMPLATE = 'uri-template';
    case REGEX = 'regex';
}
