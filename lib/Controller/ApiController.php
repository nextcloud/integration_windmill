<?php

declare(strict_types=1);
/**
 * SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

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
	 * @return DataResponse<Http::STATUS_OK, false|string, array{}>
	 *
	 * 200: event list
	 */
	#[ApiRoute(verb: 'GET', url: 'api/v1/list/events')]
	#[NoAdminRequired]
	#[NoCSRFRequired]
	public function listEvents(): DataResponse {

		$events = [];
		if (class_exists('OCA\\Forms\\Events\\FormSubmittedEvent')) {
			$events[] = [
				'name' => 'FormSubmittedEvent',
				'description' => 'A submission to a form in Nextcloud Forms',
				'path' => "OCA\Forms\Events\FormSubmittedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'form' => [
							'id' => 'int',
							'hash' => 'string',
							'title' => 'string',
							'description' => 'string',
							'ownerId' => 'string',
							'fileId' => 'string|null',
							'fileFormat' => 'string|null',
							'created' => 'int',
							'access' => 'int',
							'expires' => 'int',
							'isAnonymous' => 'bool',
							'submitMultiple' => 'bool',
							'showExpiration' => 'bool',
							'lastUpdated' => 'int',
							'submissionMessage' => 'string|null',
							'state' => 'int',
						],
						'submission' => [
							'id' => 'int',
							'formId' => 'int',
							'userId' => 'string',
							'timestamp' => 'int',
						],
					]
				],
			];
		}

		if (class_exists('OCA\\Tables\\Event\\RowAddedEvent')) {
			$events[] = [
				'name' => 'RowAddedEvent',
				'description' => 'A row has been added to a table in Nextcloud Tables',
				'path' => "OCA\Tables\Event\RowAddedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'tableId' => 'int',
						'rowId' => 'int',
						'previousValues' => ' null|array<int, mixed>',
						'values' => 'null|array<int, mixed>',
					]
				],
			];
		}

		if (class_exists('OCA\\Tables\\Event\\RowDeletedEvent')) {
			$events[] = [
				'name' => 'RowDeletedEvent',
				'description' => 'A row has been deleted from a table in Nextcloud Tables',
				'path' => "OCA\Tables\Event\RowDeletedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'tableId' => 'int',
						'rowId' => 'int',
						'previousValues' => ' null|array<int, mixed>',
						'values' => 'null|array<int, mixed>',
					]
				],
			];
		}

		if (class_exists('OCA\\Tables\\Event\\RowUpdatedEvent')) {
			$events[] = [
				'name' => 'RowUpdatedEvent',
				'description' => 'A row has been updated in a table in Nextcloud Tables',
				'path' => "OCA\Tables\Event\RowUpdatedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'tableId' => 'int',
						'rowId' => 'int',
						'previousValues' => ' null|array<int, mixed>',
						'values' => 'null|array<int, mixed>',
					]
				],
			];
		}

		if (class_exists('OCP\\Calendar\\Events\\CalendarObjectCreatedEvent')) {
			$events[] = [
				'name' => 'CalendarObjectCreatedEvent',
				'description' => 'A new object has been created in a Nextcloud calendar',
				'path' => "OCP\Calendar\Events\CalendarObjectCreatedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'calendarId' => 'int',
						'calendarData' => [
							'id' => 'int',
							'uri' => 'string',
							'{http://calendarserver.org/ns/}getctag' => 'string',
							'{http://sabredav.org/ns}sync-token' => 'int',
							'{urn:ietf:params:xml:ns:caldav}supported-calendar-component-set' => 'Sabre\CalDAV\Xml\Property\SupportedCalendarComponentSet',
							'{urn:ietf:params:xml:ns:caldav}schedule-calendar-transp' => 'Sabre\CalDAV\Xml\Property\ScheduleCalendarTransp',
							'{urn:ietf:params:xml:ns:caldav}calendar-timezone' => 'string|null',
						],
						'shares' => [[
							'href' => 'string',
							'commonName' => 'string',
							'status' => 'int',
							'readOnly' => 'bool',
							'{http://owncloud.org/ns}principal' => 'string',
							'{http://owncloud.org/ns}group-share' => 'bool',
						]],
						'objectData' => [
							'id' => 'int',
							'uri' => 'string',
							'lastmodified' => 'int',
							'etag' => 'string',
							'calendarid' => 'int',
							'size' => 'int',
							'component' => 'string|null',
							'classification' => 'int',
						],

					]
				],
			];
		}

		if (class_exists('OCP\\Calendar\\Events\\CalendarObjectMovedEvent')) {
			$events[] = [
				'name' => 'CalendarObjectMovedEvent',
				'description' => 'An object has been moved from a Nextcloud calendar to another',
				'path' => "OCP\Calendar\Events\CalendarObjectMovedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'sourceCalendarId' => 'int',
						'sourceCalendarData' => [
							'id' => 'int',
							'uri' => 'string',
							'{http://calendarserver.org/ns/}getctag' => 'string',
							'{http://sabredav.org/ns}sync-token' => 'int',
							'{urn:ietf:params:xml:ns:caldav}supported-calendar-component-set' => 'Sabre\CalDAV\Xml\Property\SupportedCalendarComponentSet',
							'{urn:ietf:params:xml:ns:caldav}schedule-calendar-transp' => 'Sabre\CalDAV\Xml\Property\ScheduleCalendarTransp',
							'{urn:ietf:params:xml:ns:caldav}calendar-timezone' => 'string|null',
						],
						'targetCalendarId' => 'int',
						'targetCalendarData' => [
							'id' => 'int',
							'uri' => 'string',
							'{http://calendarserver.org/ns/}getctag' => 'string',
							'{http://sabredav.org/ns}sync-token' => 'int',
							'{urn:ietf:params:xml:ns:caldav}supported-calendar-component-set' => 'Sabre\CalDAV\Xml\Property\SupportedCalendarComponentSet',
							'{urn:ietf:params:xml:ns:caldav}schedule-calendar-transp' => 'Sabre\CalDAV\Xml\Property\ScheduleCalendarTransp',
							'{urn:ietf:params:xml:ns:caldav}calendar-timezone' => 'string|null',
						],
						'sourceShares' => [[
							'href' => 'string',
							'commonName' => 'string',
							'status' => 'int',
							'readOnly' => 'bool',
							'{http://owncloud.org/ns}principal' => 'string',
							'{http://owncloud.org/ns}group-share' => 'bool',
						]],
						'targetShares' => [[
							'href' => 'string',
							'commonName' => 'string',
							'status' => 'int',
							'readOnly' => 'bool',
							'{http://owncloud.org/ns}principal' => 'string',
							'{http://owncloud.org/ns}group-share' => 'bool',
						]],
						'objectData' => [
							'id' => 'int',
							'uri' => 'string',
							'lastmodified' => 'int',
							'etag' => 'string',
							'calendarid' => 'int',
							'size' => 'int',
							'component' => 'string|null',
							'classification' => 'int',
						],

					]
				],
			];
		}

		if (class_exists('OCP\\Calendar\\Events\\CalendarObjectMovedToTrashEvent')) {
			$events[] = [
				'name' => 'CalendarObjectMovedToTrashEvent',
				'description' => 'An object has been moved to the trash in a Nextcloud calendar',
				'path' => "OCP\Calendar\Events\CalendarObjectMovedToTrashEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'calendarId' => 'int',
						'calendarData' => [
							'id' => 'int',
							'uri' => 'string',
							'{http://calendarserver.org/ns/}getctag' => 'string',
							'{http://sabredav.org/ns}sync-token' => 'int',
							'{urn:ietf:params:xml:ns:caldav}supported-calendar-component-set' => 'Sabre\CalDAV\Xml\Property\SupportedCalendarComponentSet',
							'{urn:ietf:params:xml:ns:caldav}schedule-calendar-transp' => 'Sabre\CalDAV\Xml\Property\ScheduleCalendarTransp',
							'{urn:ietf:params:xml:ns:caldav}calendar-timezone' => 'string|null',
						],
						'shares' => [[
							'href' => 'string',
							'commonName' => 'string',
							'status' => 'int',
							'readOnly' => 'bool',
							'{http://owncloud.org/ns}principal' => 'string',
							'{http://owncloud.org/ns}group-share' => 'bool',
						]],
						'objectData' => [
							'id' => 'int',
							'uri' => 'string',
							'lastmodified' => 'int',
							'etag' => 'string',
							'calendarid' => 'int',
							'size' => 'int',
							'component' => 'string|null',
							'classification' => 'int',
						],

					]
				],
			];
		}

		if (class_exists('OCP\\Calendar\\Events\\CalendarObjectRestoredEvent')) {
			$events[] = [
				'name' => 'CalendarObjectRestoredEvent',
				'description' => 'An object has been restored from trash in a Nextcloud calendar',
				'path' => "OCP\Calendar\Events\CalendarObjectRestoredEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'calendarId' => 'int',
						'calendarData' => [
							'id' => 'int',
							'uri' => 'string',
							'{http://calendarserver.org/ns/}getctag' => 'string',
							'{http://sabredav.org/ns}sync-token' => 'int',
							'{urn:ietf:params:xml:ns:caldav}supported-calendar-component-set' => 'Sabre\CalDAV\Xml\Property\SupportedCalendarComponentSet',
							'{urn:ietf:params:xml:ns:caldav}schedule-calendar-transp' => 'Sabre\CalDAV\Xml\Property\ScheduleCalendarTransp',
							'{urn:ietf:params:xml:ns:caldav}calendar-timezone' => 'string|null',
						],
						'shares' => [[
							'href' => 'string',
							'commonName' => 'string',
							'status' => 'int',
							'readOnly' => 'bool',
							'{http://owncloud.org/ns}principal' => 'string',
							'{http://owncloud.org/ns}group-share' => 'bool',
						]],
						'objectData' => [
							'id' => 'int',
							'uri' => 'string',
							'lastmodified' => 'int',
							'etag' => 'string',
							'calendarid' => 'int',
							'size' => 'int',
							'component' => 'string|null',
							'classification' => 'int',
						],

					]
				],
			];
		}

		if (class_exists('OCP\\Calendar\\Events\\CalendarObjectUpdatedEvent')) {
			$events[] = [
				'name' => 'CalendarObjectUpdatedEvent',
				'description' => 'An object has been changed in a Nextcloud calendar',
				'path' => "OCP\Calendar\Events\CalendarObjectUpdatedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'calendarId' => 'int',
						'calendarData' => [
							'id' => 'int',
							'uri' => 'string',
							'{http://calendarserver.org/ns/}getctag' => 'string',
							'{http://sabredav.org/ns}sync-token' => 'int',
							'{urn:ietf:params:xml:ns:caldav}supported-calendar-component-set' => 'Sabre\CalDAV\Xml\Property\SupportedCalendarComponentSet',
							'{urn:ietf:params:xml:ns:caldav}schedule-calendar-transp' => 'Sabre\CalDAV\Xml\Property\ScheduleCalendarTransp',
							'{urn:ietf:params:xml:ns:caldav}calendar-timezone' => 'string|null',
						],
						'shares' => [[
							'href' => 'string',
							'commonName' => 'string',
							'status' => 'int',
							'readOnly' => 'bool',
							'{http://owncloud.org/ns}principal' => 'string',
							'{http://owncloud.org/ns}group-share' => 'bool',
						]],
						'objectData' => [
							'id' => 'int',
							'uri' => 'string',
							'lastmodified' => 'int',
							'etag' => 'string',
							'calendarid' => 'int',
							'size' => 'int',
							'component' => 'string|null',
							'classification' => 'int',
						],

					]
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\BeforeNodeCreatedEvent')) {
			$events[] = [
				'name' => 'BeforeNodeCreatedEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) will be created',
				'path' => "OCP\Files\Events\Node\BeforeNodeCreatedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'node' => ['id' => 'string', 'path' => 'string']
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\BeforeNodeTouchedEvent')) {
			$events[] = [
				'name' => 'BeforeNodeTouchedEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) will be changed',
				'path' => "OCP\Files\Events\Node\BeforeNodeTouchedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'node' => ['id' => 'string', 'path' => 'string']
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\BeforeNodeWrittenEvent')) {
			$events[] = [
				'name' => 'BeforeNodeWrittenEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) will be written',
				'path' => "OCP\Files\Events\Node\BeforeNodeWrittenEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'node' => ['id' => 'string', 'path' => 'string']
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\BeforeNodeReadEvent')) {
			$events[] = [
				'name' => 'BeforeNodeReadEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) will be read',
				'path' => "OCP\Files\Events\Node\BeforeNodeReadEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'node' => ['id' => 'string', 'path' => 'string']
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\BeforeNodeDeletedEvent')) {
			$events[] = [
				'name' => 'BeforeNodeDeletedEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) will be deleted',
				'path' => "OCP\Files\Events\Node\BeforeNodeDeletedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'node' => ['id' => 'string', 'path' => 'string']
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\BeforeNodeCopiedEvent')) {
			$events[] = [
				'name' => 'BeforeNodeCopiedEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) will be copied',
				'path' => "OCP\Files\Events\Node\BeforeNodeCopiedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'source' => ['id' => 'string', 'path' => 'string'],
						'target' => ['id' => 'string', 'path' => 'string'],
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\BeforeNodeRestoredEvent')) {
			$events[] = [
				'name' => 'BeforeNodeRestoredEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) will be restored',
				'path' => "OCP\Files\Events\Node\BeforeNodeRestoredEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'source' => ['id' => 'string', 'path' => 'string'],
						'target' => ['id' => 'string', 'path' => 'string'],
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\BeforeNodeRenamedEvent')) {
			$events[] = [
				'name' => 'BeforeNodeRenamedEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) will be renamed',
				'path' => "OCP\Files\Events\Node\BeforeNodeRenamedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'source' => ['id' => 'string', 'path' => 'string'],
						'target' => ['id' => 'string', 'path' => 'string'],
					],
				],
			];
		}



		if (class_exists('OCP\\Files\\Events\\Node\\NodeCreatedEvent')) {
			$events[] = [
				'name' => 'NodeCreatedEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) has been created',
				'path' => "OCP\Files\Events\Node\NodeCreatedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'node' => ['id' => 'string', 'path' => 'string']
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\NodeTouchedEvent')) {
			$events[] = [
				'name' => 'NodeTouchedEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) has been changed',
				'path' => "OCP\Files\Events\Node\NodeTouchedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'node' => ['id' => 'string', 'path' => 'string']
					],
				],
			];
		}



		if (class_exists('OCP\\Files\\Events\\Node\\NodeWrittenEvent')) {
			$events[] = [
				'name' => 'NodeWrittenEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) has been written',
				'path' => "OCP\Files\Events\Node\NodeWrittenEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'node' => ['id' => 'string', 'path' => 'string']
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\NodeDeletedEvent')) {
			$events[] = [
				'name' => 'NodeDeletedEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) has been deleted',
				'path' => "OCP\Files\Events\Node\NodeDeletedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'node' => ['id' => 'string', 'path' => 'string']
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\NodeCopiedEvent')) {
			$events[] = [
				'name' => 'NodeCopiedEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) has been copied',
				'path' => "OCP\Files\Events\Node\NodeCopiedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'source' => ['id' => 'string', 'path' => 'string'],
						'target' => ['id' => 'string', 'path' => 'string'],
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\NodeRestoredEvent')) {
			$events[] = [
				'name' => 'NodeRestoredEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) has been restored',
				'path' => "OCP\Files\Events\Node\NodeRestoredEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'source' => ['id' => 'string', 'path' => 'string'],
						'target' => ['id' => 'string', 'path' => 'string'],
					],
				],
			];
		}

		if (class_exists('OCP\\Files\\Events\\Node\\NodeRenamedEvent')) {
			$events[] = [
				'name' => 'NodeRenamedEvent',
				'description' => 'A node in Nextcloud (a file/folder/similar) has been renamed',
				'path' => "OCP\Files\Events\Node\NodeRenamedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'source' => ['id' => 'string', 'path' => 'string'],
						'target' => ['id' => 'string', 'path' => 'string'],
					],
				],
			];
		}

		if (class_exists('OCP\\SystemTag\\TagAssignedEvent')) {
			$events[] = [
				'name' => 'TagAssignedEvent',
				'description' => 'A tag has been added to an object in Nextcloud',
				'path' => "OCP\SystemTag\TagAssignedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'objectType' => 'string (e.g. \'files\')',
						'objectIds' => 'string[]',
						'tagId' => 'int[]',
					],
				],
			];
		}

		if (class_exists('OCP\\SystemTag\\TagUnassignedEvent')) {
			$events[] = [
				'name' => 'TagUnassignedEvent',
				'description' => 'A tag has been removed from an object in Nextcloud',
				'path' => "OCP\SystemTag\TagUnassignedEvent",
				'parameters' => [
					'user' => ['uid' => 'string', 'displayName' => 'string'],
					'time' => 'int',
					'event' => [
						'class' => 'string',
						'objectType' => 'string (e.g. \'files\')',
						'objectIds' => 'string[]',
						'tagId' => 'int[]',
					],
				],
			];
		}


		return new DataResponse(json_encode($events), Http::STATUS_OK);
	}
}
