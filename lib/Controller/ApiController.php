<?php

declare(strict_types=1);

namespace OCA\Windmill\Controller;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\Attribute\ApiRoute;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\OCSController;

class ApiController extends OCSController {

		/**
	 * List all events that can be registered as a webhook
	 *
	 * @return DataResponse<Http::STATUS_OK, array<string, mixed>, array{}>|DataResponse<Http::STATUS_NOT_FOUND, array{}, array{}>
	 *
	 * 200: event list
	 */
	#[ApiRoute(verb: 'GET', url: 'api/v1/list/events')]
	#[NoAdminRequired]
	#[NoCSRFRequired]
	public function listEvents(): DataResponse {

	$events = [
				[
					"name" => "FormSubmittedEvent",
					"description" => "A submission to a form in Nextcloud Forms",
					"path" => "OCA\Forms\Events\FormSubmittedEvent",
					"parameters" => [
						"user" => ["uid" => "string", "displayName" => "string"],
						"time" => "int",
						"event" => [
							"class" => "string",
							"form" => [
							"id" => "int",
							"hash" => "string",
							"title" => "string",
							"description" => "string",
							"ownerId" => "string",
							"fileId" => "string|null",
							"fileFormat" => "string|null",
							"created" => "int",
							"access" => "int",
							"expires" => "int",
							"isAnonymous" => "bool",
							"submitMultiple"  => "bool",
							"showExpiration" => "bool",
							"lastUpdated"  => "int",
							"submissionMessage" => "string|null",
							"state" => "int",
							],
							"submission" => [
							"id" => "int",
							"formId" => "int",
							"userId" => "string",
							"timestamp" => "int",
							],
						]
					],
				],
				[
					"name" => "NodeWrittenEvent",
					"description" => "A node in Nextcloud (a file/folder/similar) has been written",
					"path" => "OCP\Files\Events\Node\NodeWrittenEvent",
					"parameters" => [
						"user" => ["uid" => "string", "displayName" => "string",
						"time" => "int",
						"event" => [
							"class" => "string",
							"node" => ["id" => "string", "path" => "string"]
						]
					],
				],
			]
	];
		return new DataResponse($events, Http::STATUS_OK);
	}
}
