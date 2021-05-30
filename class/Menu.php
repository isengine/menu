<?php

namespace is\Masters\Modules\Isengine;

use is\Helpers\System;
use is\Helpers\Objects;
use is\Helpers\Strings;

use is\Components\Router;

use is\Masters\Modules\Master;
use is\Masters\View;

class Menu extends Master {
	
	public $print;
	public $map;
	public $structure;
	public $route;
	public $current;
	public $variables;
	
	public function launch() {
		
		// если нет ключа, пробуем взять ключ из СЕО
		
		$router = Router::getInstance();
		$this -> structure = $router -> structure;
		$this -> map = &$this -> structure -> original;
		//$this -> route = &$this -> structure -> original;
		
		$current = &$router -> current;
		if ($current) {
			$this -> current = &$current -> getEntryKey('name');
			$this -> route = &$current -> getEntryKey('parents');
		}
		
		$sets = &$this -> settings;
		
		//echo print_r(Objects::keys($this -> elements), 1);
		//echo '<br><br>';
		//echo print_r($this -> current, 1);
		//echo '<br>';
		//echo print_r($this -> route, 1);
		//echo '<hr>';
		
		//$state = $this -> someMethod();
		
		//$this -> eget('main-container-before') -> addClass('bef-{level}');
		
		//$r = '<nav>' . print_r($this -> print, 1) . '</nav>';
		//echo htmlentities($r);
		//echo $r;
	}
	
	public function build($target = null, $parent = null) {
		
		// параметры данного метода - чисто служебные,
		// при запуске их указывать не нужно
		
		$sets = &$this -> settings;
		
		if (!$target) {
			if ($sets['custom']) {
				$target = &$sets['custom'];
			} else {
				$target = &$this -> map;
			}
		}
		
		if (!System::typeOf($target, 'iterable')) {
			return;
		}
		
		$this -> setVariables($parent);
		
		$print = null;
		$type = $parent ? 'sub' : 'main';
		
		$parent_active = null;
		$parents_list_for_active = $this -> route && $parent ? Strings::split($parent, ':') : null;
		if ($parents_list_for_active) {
			foreach ($parents_list_for_active as $key => $item) {
				$parent_active = $item === $this -> route[$key];
			}
			unset($key, $item);
		}
		
		$wrapper   = &$this -> eget($type . '-wrapper');
		$before    = &$this -> eget($type . '-container-before');
		$after     = &$this -> eget($type . '-container-after');
		$container = &$this -> eget($type . '-container');
		$it_before = &$this -> eget($type . '-item-before');
		$it_after  = &$this -> eget($type . '-item-after');
		
		if ($wrapper) {
			if ($parent_active && $sets['classes']['wrapper-active']) {
				$wrapper -> addClass($sets['classes']['wrapper-active']);
			} else {
				$wrapper -> leaveFirstClass();
			}
			$print .= $wrapper -> open();
		}
		
		if ($before) {
			$print .= $before -> open();
			$print .= $before -> content();
			$print .= $before -> close();
		}
		
		if ($container) {
			if ($parent_active && $sets['classes']['container-active']) {
				$container -> addClass($sets['classes']['container-active']);
			} else {
				$container -> leaveFirstClass();
			}
			$print .= $container -> open();
		}
		
		if ($it_before) {
			$print .= $it_before -> open();
			$print .= $it_before -> content();
			$print .= $it_before -> close();
		}
		
		$this -> print .= $this -> variables($print);
		unset($print);
		
		foreach ($target as $key => $item) {
			
			$sub = System::typeOf($item, 'iterable');
			$name = ($parent ? $parent . ':' : null) . $key;
			$active = $name === $this -> current;
			
			if ($sets['disable'] && Objects::match($sets['disable'], $name)) {
				continue;
			}
			
			$this -> setVariables($name);
			
			if (!$parents_list_for_active) {
				$parent_active = $sub && $this -> route && Objects::first($this -> route, 'value') === $name;
			} elseif ($this -> current === $name) {
				$parent_active = null;
			}
			
			$i                 = &$this -> eget($type . '-item');
			$i_active          = &$this -> eget($type . '-item-active');
			$i_dropdown        = &$this -> eget($type . '-item-dropdown');
			$i_dropdown_active = &$this -> eget($type . '-item-dropdown-active');
			
			if (
				$sub &&
				($i_dropdown || $i_dropdown_active) &&
				(!$sets['levels'] || $sets['levels'] && $this -> variables['level'] + 1 < $sets['levels'])
			) {
				if ($active && $i_dropdown_active) {
					$it = &$i_dropdown_active;
				} else {
					$it = &$i_dropdown;
				}
			} else {
				if ($active && $i_active) {
					$it = &$i_active;
				} else {
					$it = &$i;
				}
			}
			
			if ($active && $sets['classes']['item-active']) {
				$it -> addClass($sets['classes']['item-active']);
			}
			if ($parent_active && $sets['classes']['item-parents-active']) {
				$it -> addClass($sets['classes']['item-parents-active']);
			}
			
			$link_before = &$this -> eget($type . '-link-before');
			$link_after  = &$this -> eget($type . '-link-after');

			$l                 = &$this -> eget($type . '-link');
			$l_active          = &$this -> eget($type . '-link-active');
			$l_dropdown        = &$this -> eget($type . '-link-dropdown');
			$l_dropdown_active = &$this -> eget($type . '-link-dropdown-active');
			
			if (
				$sub &&
				($l_dropdown || $l_dropdown_active) &&
				(!$sets['levels'] || $sets['levels'] && $this -> variables['level'] + 1 < $sets['levels'])
			) {
				if ($active && $l_dropdown_active) {
					$link = &$l_dropdown_active;
					if ($sets['link-active'] && $sets['link-dropdown'] && $link -> getTag() === 'a') {
						$link -> addLink('{link}');
					}
				} else {
					$link = &$l_dropdown;
					if ($sets['link-dropdown'] && $link -> getTag() === 'a') {
						$link -> addLink('{link}');
					}
				}
			} else {
				if ($active && $l_active) {
					$link = &$l_active;
					if ($sets['link-active'] && $link -> getTag() === 'a') {
						$link -> addLink('{link}');
					}
				} else {
					$link = &$l;
					if ($sets['link-auto'] && $link -> getTag() === 'a') {
						$link -> addLink('{link}');
					}
				}
			}
			
			if ($active && $sets['classes']['link-active']) {
				$link -> addClass($sets['classes']['link-active']);
			}
			if ($parent_active && $sets['classes']['link-parents-active']) {
				$link -> addClass($sets['classes']['link-parents-active']);
			}
			
			$in_before   = &$this -> eget($type . '-inner-before');
			$in_after    = &$this -> eget($type . '-inner-after');
			$in          = &$this -> eget($type . '-inner');
			
			// before subitem
			
			if ($it) {
				$print .= $it -> open();
				$print .= $it -> content();
			}
				
				if ($link_before) {
					$print .= $link_before -> open();
					$print .= $link_before -> content();
					$print .= $link_before -> close();
				}
				
				if ($link) {
					$print .= $link -> open();
					$print .= $link -> content();
				}
					
					if ($in_before) {
						$print .= $in_before -> open();
						$print .= $in_before -> content();
						$print .= $in_before -> close();
					}
					
					if ($in) {
						if ($sets['lang-auto']) {
							$in -> addContent('{lang}');
						}
						$print .= $in -> open();
						$print .= $in -> content();
						$print .= $in -> close();
					}
					
					if ($in_after) {
						$print .= $in_after -> open();
						$print .= $in_after -> content();
						$print .= $in_after -> close();
					}
					
				if ($link) {
					$print .= $link -> close();
				}
				
				// subitem
				
				$this -> print .= $this -> variables($print);
				unset($print);
				
				if (
					$sub &&
					(!$sets['levels'] || $sets['levels'] && $this -> variables['level'] + 1 < $sets['levels'])
				) {
					$this -> build($item, $name);
				}
				
				// after subitem
				
				if ($link_after) {
					$print .= $link_after -> open();
					$print .= $link_after -> content();
					$print .= $link_after -> close();
				}
				
			if ($it) {
				$print .= $it -> close();
			}
			
			$this -> print .= $this -> variables($print);
			unset($print);
			
		}
		unset($key, $item);
		
		$this -> setVariables($parent);
		
		if ($it_after) {
			$print .= $it_after -> open();
			$print .= $it_after -> content();
			$print .= $it_after -> close();
			
			$this -> print .= $this -> variables($print);
			unset($print);
		}
		
		if ($container) {
			$this -> print .= $container -> close();
		}
		
		if ($after) {
			$print .= $after -> open();
			$print .= $after -> content();
			$print .= $after -> close();
			
			$this -> print .= $this -> variables($print);
			unset($print);
		}
		
		if ($wrapper) {
			$this -> print .= $wrapper -> close();
		}
		
	}
	
	public function print() {
		echo $this -> print;
	}
	
	public function variables($data) {
		
		return preg_replace_callback('/\{\w+\}/ui', function($match){
			$item = reset($match);
			$item = Strings::get($item, 1, 1, true);
			return $this -> variables[$item];
			//$result = $this -> variables[$item];
			//return System::set($result) ? $result : 'null';
		}, $data);
		
	}
	
	public function setVariables($name) {
		
		$view = View::getInstance();
		$lang = $view -> get('lang|menu');
		
		$data = $name ? $this -> structure -> getDataByName($name) : null;
		$i = $name ? $this -> structure -> getByName($name) : null;
		$parents = $i ? $i -> getEntryKey('parents') : null;
		
		if (!$data['level']) $data['level'] = 0;
		
		$this -> variables = [
			'id' => $i ? $i -> getEntryKey('id') : null,
			'name' => $data['name'],
			'fullname' => Strings::replace($name, ':', '-'),
			'lang' => $lang[$name],
			'parents' => $parents ? Strings::join($parents, '-') : null,
			'parent' => $parents ? Objects::last($parents, 'value') : null,
			'link' => $data['link'],
			'level' => $data['level']
		];
		
	}
	
}

?>