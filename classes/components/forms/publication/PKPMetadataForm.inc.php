<?php
/**
 * @file classes/components/form/publication/PKPMetadataForm.inc.php
 *
 * Copyright (c) 2014-2019 Simon Fraser University
 * Copyright (c) 2000-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class PKPMetadataForm
 * @ingroup classes_controllers_form
 *
 * @brief A preset form for setting a publication's metadata fields
 */
namespace PKP\components\forms\publication;
use \PKP\components\forms\FormComponent;
use \PKP\components\forms\FieldControlledVocab;
use \PKP\components\forms\FieldText;

define('FORM_METADATA', 'metadata');

class PKPMetadataForm extends FormComponent {
	/** @copydoc FormComponent::$id */
	public $id = FORM_METADATA;

	/** @copydoc FormComponent::$method */
	public $method = 'PUT';

	/**
	 * Constructor
	 *
	 * @param $action string URL to submit the form to
	 * @param $locales array Supported locales
	 * @param $publication Publication The publication to change settings for
	 * @param $submissionContext Context The journal or press of the submission.
	 * @param $suggestionUrlBase string The base URL to get suggestions for controlled vocab.
	 */
	public function __construct($action, $locales, $publication, $submissionContext, $suggestionUrlBase) {
		$this->action = $action;
		$this->successMessage = __('publication.metadata.success');
		$this->locales = $locales;

		// Load constants
		\DAORegistry::getDAO('SubmissionKeywordDAO');
		\DAORegistry::getDAO('SubmissionSubjectDAO');
		\DAORegistry::getDAO('SubmissionDisciplineDAO');
		\DAORegistry::getDAO('SubmissionLanguageDAO');
		\DAORegistry::getDAO('SubmissionAgencyDAO');

		if ($submissionContext->getData('keywords')) {
			$this->addField(new FieldControlledVocab('keywords', [
				'label' => __('common.keywords'),
				'tooltip' => __('manager.setup.metadata.keywords.description'),
				'isMultilingual' => true,
				'suggestionsUrl' => str_replace('__vocab__', CONTROLLED_VOCAB_SUBMISSION_KEYWORD, $suggestionUrlBase),
				'value' => $publication->getData('keywords'),
			]));
		}

		if ($submissionContext->getData('subjects')) {
			$this->addField(new FieldControlledVocab('subjects', [
				'label' => __('common.subjects'),
				'tooltip' => __('manager.setup.metadata.subjects.description'),
				'isMultilingual' => true,
				'suggestionsUrl' => str_replace('__vocab__', CONTROLLED_VOCAB_SUBMISSION_SUBJECT, $suggestionUrlBase),
				'value' => $publication->getData('subjects'),
			]));
		}

		if ($submissionContext->getData('disciplines')) {
			$this->addField(new FieldControlledVocab('disciplines', [
				'label' => __('search.discipline'),
				'tooltip' => __('manager.setup.metadata.disciplines.description'),
				'isMultilingual' => true,
				'suggestionsUrl' => str_replace('__vocab__', CONTROLLED_VOCAB_SUBMISSION_DISCIPLINE, $suggestionUrlBase),
				'value' => $publication->getData('disciplines'),
			]));
		}

		if ($submissionContext->getData('languages')) {
			$this->addField(new FieldControlledVocab('languages', [
				'label' => __('common.languages'),
				'tooltip' => __('manager.setup.metadata.languages.description'),
				'isMultilingual' => true,
				'suggestionsUrl' => str_replace('__vocab__', CONTROLLED_VOCAB_SUBMISSION_LANGUAGE, $suggestionUrlBase),
				'value' => $publication->getData('languages'),
			]));
		}

		if ($submissionContext->getData('supportingAgencies')) {
			$this->addField(new FieldControlledVocab('supportingAgencies', [
				'label' => __('submission.supportingAgencies'),
				'tooltip' => __('manager.setup.metadata.agencies.description'),
				'isMultilingual' => true,
				'suggestionsUrl' => str_replace('__vocab__', CONTROLLED_VOCAB_SUBMISSION_AGENCY, $suggestionUrlBase),
				'value' => $publication->getData('supportingAgencies'),
			]));
		}

		if ($submissionContext->getData('coverage')) {
			$this->addField(new FieldText('coverage', [
				'label' => __('manager.setup.metadata.coverage'),
				'tooltip' => __('manager.setup.metadata.coverage.description'),
				'isMultilingual' => true,
				'value' => $publication->getData('coverage'),
			]));
		}

		if ($submissionContext->getData('rights')) {
			$this->addField(new FieldText('rights', [
				'label' => __('submission.rights'),
				'tooltip' => __('manager.setup.metadata.rights.description'),
				'isMultilingual' => true,
				'value' => $publication->getData('rights'),
			]));
		}

		if ($submissionContext->getData('source')) {
			$this->addField(new FieldText('source', [
				'label' => __('common.source'),
				'tooltip' => __('manager.setup.metadata.source.description'),
				'isMultilingual' => true,
				'value' => $publication->getData('source'),
			]));
		}

		if ($submissionContext->getData('type')) {
			$this->addField(new FieldText('type', [
				'label' => __('common.type'),
				'tooltip' => __('manager.setup.metadata.type.description'),
				'isMultilingual' => true,
				'value' => $publication->getData('type'),
			]));
		}
	}
}
