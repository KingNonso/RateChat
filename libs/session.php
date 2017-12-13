<?php

    class Session {

        public static function exists($name) {
            return (isset($_SESSION[$name])) ? true : false;
        }

        public static function put($name, $value) {
            if (self::exists($name) && ($name == 'home' || $name == 'error')) {
                ///$session = self::get($name);
                return $_SESSION[$name] .= "<p>".$value."<p>";
            } else {
                return $_SESSION[$name] = $value;
            }

        }

        public static function get($name) {
            if (isset($_SESSION[$name]))
                return $_SESSION[$name];
        }

        public static function delete($name = NULL) {
            if (isset($name) && self::exists($name)) {
                unset($_SESSION[$name]);
            }
            //session_destroy();
        }

        public static function flash($name, $string = '') {
            if (self::exists($name)) {
                $session = self::get($name);
                self::delete($name);
                return $session;
            } else {
                self::put($name, $string);
            }
        }

        public static function logged_in() {
            return isset($_SESSION['user_id']);
        }

        public static function confirm_logged_in() {
            if (!self::logged_in()) {
                Redirect::to(URL."members");
            }
        }

        public static function breadcrumbs($separator = ' &raquo; ', $home = 'Home') {

            $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
            $base_url = substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/')) . '://' . $_SERVER['HTTP_HOST'] . '/';
            $breadcrumbs = array("<a href=\"$base_url\">$home</a>");
            $tmp = array_keys($path);
            $last = end($tmp);
            unset($tmp);

            foreach ($path as $x => $crumb) {
                $title = ucwords(str_replace(array('.php', '_'), array('', ' '), $crumb));
                if ($x == 1) {
                    $breadcrumbs[] = "<a href=\"$base_url$crumb\">$title</a>";
                } elseif ($x > 1 && $x < $last) {
                    $tmp = "<a href=\"$base_url";
                    for ($i = 1; $i <= $x; $i++) {
                        $tmp .= $path[$i] . '/';
                    }
                    $tmp .= "\">$title</a>";
                    $breadcrumbs[] = $tmp;
                    unset($tmp);
                } else {
                    $breadcrumbs[] = "$title";
                }
            }

            return implode($separator, $breadcrumbs);
        }

        //homecrumbs is a variant of the breadcrumb, just for the site outside
        public static function homecrumbs($tag = null, $separator = null, $home = 'Home') {
            //$separator = ' &raquo; '
            if(isset($tag)){
                $open = "<{$tag}>";
                $close = "</{$tag}>";
            }else{
                $open = '';
                $close = '';
            }

            $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
            $base_url = substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/')) . '://' . $_SERVER['HTTP_HOST'] . '/';
            $breadcrumbs = array("$open<a href=\"$base_url\">$home</a>$close");
            $tmp = array_keys($path);
            $last = end($tmp);
            unset($tmp);

            foreach ($path as $x => $crumb) {
                $title = ucwords(str_replace(array('.php', '_'), array('', ' '), $crumb));
                if ($x == 1) {
                    $breadcrumbs[] = "$open<a href=\"$base_url$crumb\">$title</a>$close";
                } elseif ($x > 1 && $x < $last) {
                    $tmp = "$open<a href=\"$base_url";
                    for ($i = 1; $i <= $x; $i++) {
                        $tmp .= $path[$i] . '/';
                    }
                    $tmp = chop($tmp,'/'); //remove trailing slashes
                    $tmp .= "\">$title</a>$close";
                    $breadcrumbs[] = $tmp;
                    unset($tmp);
                } else {
                    if(isset($tag)){
                        $breadcrumbs[] = "<{$tag} class=\"active\"><a href=\"#\" >$title - You are here</a></{$tag}>";
                    }else{
                        $breadcrumbs[] = "$title - You are here";
                    }

                }
            }

            return implode($separator, $breadcrumbs);
        }

    }

    /*
     *    public static function set($key, $value) {
      $_SESSION[$key] = $value;
      }

      public static function get($key) {
      if(isset($_SESSION[$key]))
      return $_SESSION[$key];
      }

      public static function destroy() {
      //unset($_SESSION);
      session_destroy();
      }

     */
