<?php

/**
 * Прототип класса формы.
 */
abstract class FormPrototype implements FormInterface {
  public $autocompletePath;

  /**
   * Конструктор класса.
   */
  public function __construct() {
    $this->autocompletePath = 'form/prototype/autocomplete';
  }

  /**
   * Имя функции темы.
   *
   * @inheritdoc
   */
  public function theme() {
    return '';
  }

  /**
   * Поля формы.
   *
   * @inheritdoc
   */
  abstract public function form($form, &$form_state);

  /**
   * Валидация формы.
   *
   * @inheritdoc
   */
  public function validate($form, &$form_state) {
    return $this;
  }

  /**
   * Обработка формы.
   *
   * @inheritdoc
   */
  public function submit($form, &$form_state) {
    return $this;
  }

  /**
   * Ajax обработка формы.
   *
   * @inheritdoc
   */
  public function ajax($form, &$form_state) {
    return NULL;
  }

  /**
   * Билд формы.
   *
   * @inheritdoc
   */
  public function build($form, &$form_state, array $settings = array()) {
    if (!is_array($form)) {
      $form = array();
    }

    // регистрация прототипа
    $form['#prototype'] = array(
      'class' => get_class($this),
      'settings' => $settings,
      'validator' => array(),
      'submit' => array(),
    );
    $form['#attached']['css'][] = drupal_get_path('module', 'foundation_form') . '/css/form_prototype.css';


    // функция темы
    if ($theme = $this->theme()) {
      $form['#theme'][] = $theme;
    }

    return $this->form($form, $form_state);
  }

  /**
   * Рендер формы.
   *
   * @inheritdoc
   */
  public function render(array $settings = array()) {
    $form = drupal_get_form('foundation_form_form', get_class($this), $settings);
    return drupal_render($form);
  }

  /**
   * Автозаполнение элемента формы.
   *
   * @inheritdoc
   */
  public function autocomplete($type, $search_string) {
    return array();
  }

  /**
   * Путь обработчика автозаполнения.
   *
   * @return string
   *   Сформированный путь.
   */
  public function autocompletePath($type) {
    return sprintf('%s/%s/%s', $this->autocompletePath, get_class($this), $type);
  }

  /**
   * Билд элемента скрытого поля.
   *
   * @param string $value
   *   Значение поля.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function hidden($value, array $classes = array()) {
    return array(
      '#type' => 'hidden',
      '#value' => $value,
    );
  }

  /**
   * Билд элемента скрытого поля.
   *
   * @param string $value
   *   Значение поля.
   * @param array $classes
   *   Классы поля.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function hiddenValue($value, array $classes = array()) {
    return array(
      '#type' => 'hidden',
      '#default_value' => $value,
      '#attributes' => array(
        'class' => is_array($classes) ? $classes : array($classes),
      ),
    );
  }

  /**
   * Билд элемента контейнер.
   *
   * @param bool $tree
   *   Признак древовидной структуры.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function container($tree = FALSE, $title = NULL) {
    return array(
      '#type' => 'container',
      '#prefix' => $title ? FoundationString::tag('label', $title) : '',
      '#tree' => $tree,
    );
  }

  /**
   * Билд элемента пункта.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param string $value
   *   Значение.
   * @param bool $use_tag
   *   Использовать декоратор.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function item($title, $value, $use_tag = TRUE) {
    return array(
      '#type' => 'item',
      '#title' => $title,
      '#markup' => $use_tag ? FoundationString::tag('p', $value) : $value,
    );
  }

  /**
   * Билд элемента поля веса.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param string $default_value
   *   Значение по умолчанию.
   * @param bool $required
   *   Признак обязательности.
   * @param mixed $delta
   *   Дельта поля.
   * @param mixed $classes
   *   Классы кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function weight($title, $default_value = NULL, $required = FALSE, $delta = 30, $classes = array()) {
    return array(
      '#type' => 'weight',
      '#delta' => $delta,
      '#title' => $title,
      '#required' => $required,
      '#default_value' => $default_value,
      '#attributes' => array(
        'class' => is_array($classes) ? $classes : array($classes),
      ),
    );
  }

  /**
   * Билд элемента списка.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param array $options
   *   Массив опций.
   * @param string $default_value
   *   Значение по умолчанию.
   * @param bool $required
   *   Признак обязательности.
   * @param bool $multiple
   *   Признак множественности.
   * @param mixed $classes
   *   Классы кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function select($title, array $options, $default_value = NULL, $required = FALSE, $multiple = FALSE, $classes = array()) {
    return array(
      '#type' => 'select',
      '#title' => $title,
      '#options' => $options,
      '#required' => $required,
      '#multiple' => $multiple,
      '#default_value' => $default_value,
      '#attributes' => array(
        'class' => is_array($classes) ? $classes : array($classes),
      ),
    );
  }

  /**
   * Билд чекбоксов.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param array $options
   *   Массив опций.
   * @param string $default_value
   *   Значение по умолчанию.
   * @param bool $required
   *   Признак обязательности.
   * @param bool $multiple
   *   Признак множественности.
   * @param mixed $classes
   *   Классы кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function checkboxes($title, array $options, $default_value = NULL, $required = FALSE, $multiple = FALSE, $classes = array()) {
    return array(
      '#type' => 'checkboxes',
      '#title' => $title,
      '#options' => $options,
      '#required' => $required,
      '#multiple' => $multiple,
      '#default_value' => $default_value,
      '#attributes' => array(
        'class' => is_array($classes) ? $classes : array($classes),
      ),
    );
  }

  /**
   * Билд чекбоксов.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param array $options
   *   Массив опций.
   * @param string $default_value
   *   Значение по умолчанию.
   * @param bool $required
   *   Признак обязательности.
   * @param bool $multiple
   *   Признак множественности.
   * @param mixed $classes
   *   Классы кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function radios($title, array $options, $default_value = NULL, $required = FALSE, $multiple = FALSE, $classes = array()) {
    return array(
      '#type' => 'radios',
      '#title' => $title,
      '#options' => $options,
      '#required' => $required,
      '#multiple' => $multiple,
      '#default_value' => $default_value,
      '#attributes' => array(
        'class' => is_array($classes) ? $classes : array($classes),
      ),
    );
  }

  /**
   * Билд чекбоксов.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param string $default_value
   *   Значение по умолчанию.
   * @param bool $required
   *   Признак обязательности.
   * @param bool $multiple
   *   Признак множественности.
   * @param mixed $classes
   *   Классы кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function checkbox($title, $default_value = NULL, $required = FALSE, $multiple = FALSE, $classes = array()) {
    return array(
      '#type' => 'checkbox',
      '#title' => $title,
      '#required' => $required,
      '#multiple' => $multiple,
      '#default_value' => $default_value,
      '#attributes' => array(
        'class' => is_array($classes) ? $classes : array($classes),
      ),
    );
  }

  /**
   * Билд элемента поля многострочного текста.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param string $default_value
   *   Значение по умолчанию.
   * @param bool $required
   *   Признак обязательности.
   * @param int $rows
   *   Кол-во строк.
   * @param mixed $classes
   *   Классы кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function text($title, $default_value = NULL, $required = FALSE, $rows = 5, $classes = array()) {
    return array(
      '#type' => 'textarea',
      '#title' => $title,
      '#required' => $required,
      '#rows' => $rows,
      '#default_value' => $default_value,
      '#attributes' => array(
        'class' => is_array($classes) ? $classes : array($classes),
      ),
    );
  }

  /**
   * Билд элемента поля текста.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param string $default_value
   *   Значение по умолчанию.
   * @param bool $required
   *   Признак обязательности.
   * @param mixed $classes
   *   Классы кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function textfield($title, $default_value = NULL, $required = FALSE, $classes = array()) {
    return array(
      '#type' => 'textfield',
      '#title' => $title,
      '#required' => $required,
      '#default_value' => $default_value,
      '#attributes' => array(
        'class' => is_array($classes) ? $classes : array($classes),
      ),
    );
  }

  /**
   * Билд элемента поля автодополняемого текста.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param string|null $path
   *   Путь
   * @param string|null $default_value
   *   Значение по умолчанию.
   * @param bool $required
   *   Признак обязательности.
   * @param mixed $classes
   *   Классы кнопки.
   * @param array $options
   *   Опции элемента.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function autocompleteField(
    $title,
    $path = NULL,
    $default_value = NULL,
    $required = FALSE,
    $classes = [],
    $options = []) {

    $default = [
      '#autocomplete_path' => isset($path) ? $path : $this->autocompletePath,
    ] + $options;

    return $this->textfield($title, $default_value, $required, $classes) + $default;
  }

  /**
   * Билд элемента поля числа.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param string $default_value
   *   Значение по умолчанию.
   * @param bool $required
   *   Признак обязательности.
   * @param mixed $classes
   *   Классы кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function numberfield($title, $default_value = NULL, $required = FALSE, $classes = array()) {
    return $this->textfield($title, $default_value, $required, $classes) + [
      '#theme' => 'numberfield',
      ];
  }

  /**
   * Билд элемента выбора даты.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param string $default_value
   *   Значение по умолчанию.
   * @param bool $required
   *   Признак обязательности.
   * @param mixed $classes
   *   Классы кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function datePicker($title, $default_value = NULL, $required = FALSE, $classes = array()) {
    if (is_numeric($default_value)) {
      $default_value = date('d.m.Y', $default_value);
    }

    // процессинг классов
    if (!is_array($classes)) {
      $classes = array($classes);
    }
    $classes[] = 'date-picker';

    return array(
      '#type' => 'textfield',
      '#attached' => array(
        'libraries_load' => array(array('bootstrap-datepicker')),
      ),
      '#title' => $title,
      '#required' => $required,
      '#default_value' => $default_value,
      '#attributes' => array(
        'autocomplete' => 'off',
        'class' => $classes,
      ),
    );
  }

  /**
   * Билд элемента кнопки.
   *
   * @param string $value
   *   Значение кнопки.
   * @param string $ajax_handler
   *   Обработчик кнопки.
   * @param mixed $classes
   *   Классы кнопки.
   * @param mixed $states
   *   Стейты кнопки.
   * @param string $type
   *   Тип кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function button($value, $ajax_handler = NULL, $classes = NULL, $states = NULL, $type = 'button') {
    $button = array(
      '#type' => $type,
      '#value' => $value,
      '#attributes' => array(),
      '#states' => array(),
    );

    // добавить ajax обработчик
    if ($ajax_handler) {
      $button['#prototype']['ajaxSubmit'] = $ajax_handler;
      $button['#ajax'] = array(
        'callback' => 'foundation_form_form_ajax_submit',
        'progress' => array('type' => 'none'),
      );
    }
    // добавить классы кнопки
    if ($classes) {
      $button['#attributes']['class'] = is_array($classes) ? $classes : array($classes);
    }
    // добавить классы кнопки
    if ($states) {
      $button['#states'] = $states;
    }

    return $button;
  }

  /**
   * Билд элемента сабмита.
   *
   * @param string $value
   *   Значение кнопки.
   * @param string $ajax_handler
   *   Обработчик кнопки.
   * @param mixed $classes
   *   Классы кнопки.
   * @param mixed $states
   *   Стейты кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function buttonSubmit($value, $ajax_handler = NULL, $classes = NULL, $states = NULL) {
    $submit = $this->button($value, $ajax_handler, $classes, $states, 'submit');
    $submit['#submit'][] = 'foundation_form_form_submit';
    return $submit;
  }

  /**
   * Билд элемента сабмита.
   *
   * @param string $name
   *   Значение кнопки.
   * @param string $value
   *   Значение кнопки.
   * @param string $ajax_handler
   *   Обработчик кнопки.
   *
   * @return array
   *   Массив данных элемента.
   */
  public function buttonTrigger($name, $value, $ajax_handler) {
    return array(
      '#triggering' => TRUE,
      '#name' => $name,
      '#type' => 'submit',
      '#value' => $value,
      '#prototype' => array(
        'ajaxSubmit' => $ajax_handler,
      ),
      '#submit' => array(
        'foundation_form_form_submit',
      ),
      '#ajax' => array(
        'callback' => 'foundation_form_form_ajax_submit',
        'progress' => array('type' => 'none'),
      ),
      '#attributes' => array(
        'class' => array('element-invisible'),
      ),
      '#limit_validation_errors' => array()
    );
  }

  /**
   * Билд элемента филдсет.
   *
   * @param string $title
   *   Заголовк элемента.
   * @param array $children
   *   Вложенные элементы.
   * @param array $attributes
   *   Атрибуты елемента
   *
   * @return array
   */
  public function fieldset($title, $children = [], $attributes = []) {

    $default = [
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
    ] + $attributes;

    return [
      '#type' => 'fieldset',
      '#title' => $title,
    ] + $default + $children;
  }

  /**
   * @param string $path
   * @param string|null $title
   * @param array $options
   *
   * @return array
   */
  public function link($path, $title = NULL, $options = []) {
    return [
      '#type' => 'link',
      '#title' => $title,
      '#href' => $path,
      '#options' => $options,
    ];
  }

}
