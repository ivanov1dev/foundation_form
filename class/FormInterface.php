<?php

/**
 * Интерфейс формы.
 */
interface FormInterface {

  /**
   * Имя функции темы.
   *
   * @return string
   *   Функция темы.
   */
  public function theme();

  /**
   * Поля формы.
   *
   * @return array
   *   Массив полей формы.
   */
  public function form($form, &$form_state);

  /**
   * Валидация формы.
   *
   * @return self
   *   Текущий объект.
   */
  public function validate($form, &$form_state);

  /**
   * Обработка формы.
   *
   * @return FormInterface
   *   Текущий объект.
   */
  public function submit($form, &$form_state);

  /**
   * Ajax обработка формы.
   *
   * @return FormInterface
   *   Текущий объект.
   */
  public function ajax($form, &$form_state);

  /**
   * Билд формы.
   *
   * @return array
   *   Массив данных формы.
   */
  public function build($form, &$form_state, array $settings = array());

  /**
   * Рендер формы.
   *
   * @return string
   *   Результат рендера.
   */
  public function render(array $settings = array());

  /**
   * Автозаполнение элемента формы.
   *
   * @return array
   *   Массив данных для автозаполнения.
   */
  public function autocomplete($type, $search_string);

}
