<?php

/**
 * Вспомогательные функции для форм.
 */
final class FormHelper {
  private static $parameters;

  /**
   * Массив параметров формы (из запроса).
   *
   * @return array
   *   Массив параметров запроса.
   */
  public static function getQuery() {
    if (is_null(self::$parameters)) {
      self::$parameters = drupal_get_query_parameters();
    }
    return self::$parameters;
  }

  /**
   * Параметр формы (из запроса).
   *
   * @param string $name
   *   Имя параметра.
   * @param string $default
   *   Значение по умолчанию.
   *
   * @return string
   *   Значение параметра.
   */
  public static function getQueryParam($name, $default = NULL) {
    $parameters = self::getQuery();
    if (isset($parameters[$name])) {
      $default = $parameters[$name];
    }
    return $default;
  }

  /**
   * Подготовка значения для поля "Дата".
   *
   * @param string $timestamp
   *   Дата в формате UNIX timestamp.
   *
   * @return array
   *   Массив данных.
   */
  public static function buildDate($timestamp) {
    if (!$timestamp) {
      $timestamp = time();
    }
    return array(
      'day' => date('j', $timestamp),
      'month' => date('n', $timestamp),
      'year' => date('Y', $timestamp),
    );
  }

  /**
   * Подготовка UNIX значения поля "Дата".
   *
   * @param array $value
   *   Массив данных даты.
   * @param bool $use_time
   *   Использовать время.
   *
   * @return int
   *   Дата в формате UNIX timestamp.
   */
  public static function buildTimestamp(array $value, $use_time = FALSE) {
    $value += array(
      'hour' => $use_time ? '23' : 0,
      'minute' => $use_time ? '59' : 0,
      'second' => $use_time ? '59' : 0,
    );
    return mktime($value['hour'], $value['minute'], $value['second'], $value['month'], $value['day'], $value['year']);
  }

}
