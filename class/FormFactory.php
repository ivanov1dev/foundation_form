<?php

/**
 * Фабрика форм.
 */
final class FormFactory {
  private static $forms = array();

  /**
   * Имя класса формы.
   *
   * @param string $class
   *   Имя формы.
   *
   * @return string
   *   Имя класса.
   */
  public static function className($class) {
    if (!class_exists($class)) {
      $class = sprintf('%sForm', ucfirst($class));
      if (!class_exists($class)) {
        throw new \InvalidArgumentException(sprintf('Класс формы "%s" не определен.', $class));
      }
    }
    return $class;
  }

  /**
   * Поля формы.
   *
   * @param string $class
   *   Имя класса формы.
   * @param bool $rebuild
   *   Перестроение формы.
   *
   * @return FormInterface
   *   Объект формы.
   */
  public static function get($class, $rebuild = FALSE) {
    $class = self::className($class);
    if (!isset(self::$forms[$class]) || $rebuild) {
      self::$forms[$class] = new $class();
    }
    return self::$forms[$class];
  }

}
