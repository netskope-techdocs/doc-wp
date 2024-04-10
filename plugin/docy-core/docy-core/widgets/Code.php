<?php
namespace DocyCore\Widgets;

use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Code extends Widget_Base {

    public function get_name() {
        return 'docly_code_syntax_highlighter';
    }

    public function get_title() {
        return __( 'Code Syntax Highlighter', 'docy-core' );
    }

    public function get_icon() {
        return 'eicon-editor-code';
    }

    public function get_categories() {
        return [ 'docy-elements' ];
    }

    public function get_keywords() {
        return [ 'code', 'syntax', 'highlighter', 'source code' ];
    }

    public function get_style_depends() {
        return ['prism'];
    }

    public function get_script_depends() {
        return ['prism'];
    }

    public function lng_type() {
        return [
            'markup' => __('HTML Markup', 'docy-core'),
            'css' => __('CSS', 'docy-core'),
            'clike' => __('Clike', 'docy-core'),
            'javascript' => __('JavaScript', 'docy-core'),
            'abap' => __('ABAP', 'docy-core'),
            'abnf' => __('Augmented Backus–Naur form', 'docy-core'),
            'actionscript' => __('ActionScript', 'docy-core'),
            'ada' => __('Ada', 'docy-core'),
            'apacheconf' => __('Apache Configuration', 'docy-core'),
            'apl' => __('APL', 'docy-core'),
            'applescript' => __('AppleScript', 'docy-core'),
            'arduino' => __('Arduino', 'docy-core'),
            'arff' => __('ARFF', 'docy-core'),
            'asciidoc' => __('AsciiDoc', 'docy-core'),
            'asm6502' => __('6502 Assembly', 'docy-core'),
            'aspnet' => __('ASP.NET (C#)', 'docy-core'),
            'autohotkey' => __('AutoHotkey', 'docy-core'),
            'autoit' => __('Autoit', 'docy-core'),
            'bash' => __('Bash', 'docy-core'),
            'basic' => __('BASIC', 'docy-core'),
            'batch' => __('Batch', 'docy-core'),
            'bison' => __('Bison', 'docy-core'),
            'bnf' => __('Bnf', 'docy-core'),
            'brainfuck' => __('Brainfuck', 'docy-core'),
            'bro' => __('Bro', 'docy-core'),
            'c' => __('C', 'docy-core'),
            'csharp' => __('Csharp', 'docy-core'),
            'cpp' => __('Cpp', 'docy-core'),
            'cil' => __('Cil', 'docy-core'),
            'coffeescript' => __('Coffeescript', 'docy-core'),
            'cmake' => __('Cmake', 'docy-core'),
            'clojure' => __('Clojure', 'docy-core'),
            'crystal' => __('Crystal', 'docy-core'),
            'csp' => __('Csp', 'docy-core'),
            'css-extras' => __('Css-extras', 'docy-core'),
            'd' => __('D', 'docy-core'),
            'dart' => __('Dart', 'docy-core'),
            'diff' => __('Diff', 'docy-core'),
            'django' => __('Django', 'docy-core'),
            'dns-zone-file' => __('Dns-zone-file', 'docy-core'),
            'docker' => __('Docker', 'docy-core'),
            'ebnf' => __('Ebnf', 'docy-core'),
            'eiffel' => __('Eiffel', 'docy-core'),
            'ejs' => __('Ejs', 'docy-core'),
            'elixir' => __('Elixir', 'docy-core'),
            'elm' => __('Elm', 'docy-core'),
            'erb' => __('Erb', 'docy-core'),
            'erlang' => __('Erlang', 'docy-core'),
            'fsharp' => __('Fsharp', 'docy-core'),
            'firestore-security-rules' => __('Firestore-security-rules', 'docy-core'),
            'flow' => __('Flow', 'docy-core'),
            'fortran' => __('Fortran', 'docy-core'),
            'gcode' => __('Gcode', 'docy-core'),
            'gdscript' => __('Gdscript', 'docy-core'),
            'gedcom' => __('Gedcom', 'docy-core'),
            'gherkin' => __('Gherkin', 'docy-core'),
            'git' => __('Git', 'docy-core'),
            'glsl' => __('Glsl', 'docy-core'),
            'gml' => __('Gml', 'docy-core'),
            'go' => __('Go', 'docy-core'),
            'graphql' => __('Graphql', 'docy-core'),
            'groovy' => __('Groovy', 'docy-core'),
            'haml' => __('Haml', 'docy-core'),
            'handlebars' => __('Handlebars', 'docy-core'),
            'haskell' => __('Haskell', 'docy-core'),
            'haxe' => __('Haxe', 'docy-core'),
            'hcl' => __('Hcl', 'docy-core'),
            'http' => __('Http', 'docy-core'),
            'hpkp' => __('Hpkp', 'docy-core'),
            'hsts' => __('Hsts', 'docy-core'),
            'ichigojam' => __('Ichigojam', 'docy-core'),
            'icon' => __('Icon', 'docy-core'),
            'inform7' => __('Inform7', 'docy-core'),
            'ini' => __('Ini', 'docy-core'),
            'io' => __('Io', 'docy-core'),
            'j' => __('J', 'docy-core'),
            'java' => __('Java', 'docy-core'),
            'javadoc' => __('Javadoc', 'docy-core'),
            'javadoclike' => __('Javadoclike', 'docy-core'),
            'javastacktrace' => __('Javastacktrace', 'docy-core'),
            'jolie' => __('Jolie', 'docy-core'),
            'jq' => __('Jq', 'docy-core'),
            'jsdoc' => __('Jsdoc', 'docy-core'),
            'js-extras' => __('Js-extras', 'docy-core'),
            'js-templates' => __('Js-templates', 'docy-core'),
            'json' => __('Json', 'docy-core'),
            'jsonp' => __('Jsonp', 'docy-core'),
            'json5' => __('Json5', 'docy-core'),
            'julia' => __('Julia', 'docy-core'),
            'keyman' => __('Keyman', 'docy-core'),
            'kotlin' => __('Kotlin', 'docy-core'),
            'latex' => __('Latex', 'docy-core'),
            'less' => __('Less', 'docy-core'),
            'lilypond' => __('Lilypond', 'docy-core'),
            'liquid' => __('Liquid', 'docy-core'),
            'lisp' => __('Lisp', 'docy-core'),
            'livescript' => __('Livescript', 'docy-core'),
            'lolcode' => __('Lolcode', 'docy-core'),
            'lua' => __('Lua', 'docy-core'),
            'makefile' => __('Makefile', 'docy-core'),
            'markdown' => __('Markdown', 'docy-core'),
            'markup-templating' => __('Markup-templating', 'docy-core'),
            'matlab' => __('Matlab', 'docy-core'),
            'mel' => __('Mel', 'docy-core'),
            'mizar' => __('Mizar', 'docy-core'),
            'monkey' => __('Monkey', 'docy-core'),
            'n1ql' => __('N1ql', 'docy-core'),
            'n4js' => __('N4js', 'docy-core'),
            'nand2tetris-hdl' => __('Nand2tetris-hdl', 'docy-core'),
            'nasm' => __('Nasm', 'docy-core'),
            'nginx' => __('Nginx', 'docy-core'),
            'nim' => __('Nim', 'docy-core'),
            'nix' => __('Nix', 'docy-core'),
            'nsis' => __('Nsis', 'docy-core'),
            'objectivec' => __('Objectivec', 'docy-core'),
            'ocaml' => __('Ocaml', 'docy-core'),
            'opencl' => __('Opencl', 'docy-core'),
            'oz' => __('Oz', 'docy-core'),
            'parigp' => __('Parigp', 'docy-core'),
            'parser' => __('Parser', 'docy-core'),
            'pascal' => __('Pascal', 'docy-core'),
            'pascaligo' => __('Pascaligo', 'docy-core'),
            'pcaxis' => __('Pcaxis', 'docy-core'),
            'perl' => __('Perl', 'docy-core'),
            'php' => __('Php', 'docy-core'),
            'phpdoc' => __('Phpdoc', 'docy-core'),
            'php-extras' => __('Php-extras', 'docy-core'),
            'plsql' => __('Plsql', 'docy-core'),
            'powershell' => __('Powershell', 'docy-core'),
            'processing' => __('Processing', 'docy-core'),
            'prolog' => __('Prolog', 'docy-core'),
            'properties' => __('Properties', 'docy-core'),
            'protobuf' => __('Protobuf', 'docy-core'),
            'pug' => __('Pug', 'docy-core'),
            'puppet' => __('Puppet', 'docy-core'),
            'pure' => __('Pure', 'docy-core'),
            'python' => __('Python', 'docy-core'),
            'q' => __('Q', 'docy-core'),
            'qore' => __('Qore', 'docy-core'),
            'r' => __('R', 'docy-core'),
            'jsx' => __('Jsx', 'docy-core'),
            'tsx' => __('Tsx', 'docy-core'),
            'renpy' => __('Renpy', 'docy-core'),
            'reason' => __('Reason', 'docy-core'),
            'regex' => __('Regex', 'docy-core'),
            'rest' => __('Rest', 'docy-core'),
            'rip' => __('Rip', 'docy-core'),
            'roboconf' => __('Roboconf', 'docy-core'),
            'ruby' => __('Ruby', 'docy-core'),
            'rust' => __('Rust', 'docy-core'),
            'sas' => __('Sas', 'docy-core'),
            'sass' => __('Sass', 'docy-core'),
            'scss' => __('Scss', 'docy-core'),
            'scala' => __('Scala', 'docy-core'),
            'scheme' => __('Scheme', 'docy-core'),
            'shell-session' => __('Shell-session', 'docy-core'),
            'smalltalk' => __('Smalltalk', 'docy-core'),
            'smarty' => __('Smarty', 'docy-core'),
            'soy' => __('Soy', 'docy-core'),
            'splunk-spl' => __('Splunk-spl', 'docy-core'),
            'sql' => __('Sql', 'docy-core'),
            'stylus' => __('Stylus', 'docy-core'),
            'swift' => __('Swift', 'docy-core'),
            'tap' => __('Tap', 'docy-core'),
            'tcl' => __('Tcl', 'docy-core'),
            'textile' => __('Textile', 'docy-core'),
            'toml' => __('Toml', 'docy-core'),
            'tt2' => __('Tt2', 'docy-core'),
            'turtle' => __('Turtle', 'docy-core'),
            'twig' => __('Twig', 'docy-core'),
            'typescript' => __('Typescript', 'docy-core'),
            't4-cs' => __('T4-cs', 'docy-core'),
            't4-vb' => __('T4-vb', 'docy-core'),
            't4-templating' => __('T4-templating', 'docy-core'),
            'vala' => __('Vala', 'docy-core'),
            'vbnet' => __('Vbnet', 'docy-core'),
            'velocity' => __('Velocity', 'docy-core'),
            'verilog' => __('Verilog', 'docy-core'),
            'vhdl' => __('Vhdl', 'docy-core'),
            'vim' => __('Vim', 'docy-core'),
            'visual-basic' => __('Visual-basic', 'docy-core'),
            'wasm' => __('Wasm', 'docy-core'),
            'wiki' => __('Wiki', 'docy-core'),
            'xeora' => __('Xeora', 'docy-core'),
            'xojo' => __('Xojo', 'docy-core'),
            'xquery' => __('Xquery', 'docy-core'),
            'yaml' => __('Yaml', 'docy-core'),
        ];
    }

    /**
     * Register content related controls
     */
    protected function register_controls() {
        // Source Code Section Start
        $this->start_controls_section(
            '_section_source_code',
            [
                'label' => __('Source Code', 'docy-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'lng_type',
            [
                'label' => __('Language Type', 'docy-core'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'default' => 'markup',
                'options' => $this->lng_type(),
            ]
        );

        $this->add_control(
            'theme',
            [
                'label' => __('Theme', 'docy-core'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'default' => 'prism',
                'options' => [
                    'prism' => __('Default', 'docy-core'),
                    'prism-coy' => __('Coy', 'docy-core'),
                    'prism-dark' => __('Dark', 'docy-core'),
                    'prism-funky' => __('Funky', 'docy-core'),
                    'prism-okaidia' => __('Okaidia', 'docy-core'),
                    'prism-solarizedlight' => __('Solarized light', 'docy-core'),
                    'prism-tomorrow' => __('Tomorrow', 'docy-core'),
                    'prism-twilight' => __('Twilight', 'docy-core'),
                ],
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'source_code',
            [
                'label' => __('Source Code', 'docy-core'),
                'type' => Controls_Manager::CODE,
                'rows' => 20,
                'default' => '<p class="random-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>',
                'placeholder' => __('Source Code....', 'docy-core'),
                'condition' => [
                    'lng_type!' => '',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * Style Controls
         */
        $this->start_controls_section(
            '_section_source_code_style',
            [
                'label' => __('Style', 'docy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'source_code_box_height',
            [
                'label' => __('Height', 'docy-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .docy-source-code pre' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => __('Box Border', 'docy-core'),
                'selector' => '{{WRAPPER}}  .docy-source-code pre[class*="language-"]',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => __('Border Radius', 'docy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .docy-source-code pre[class*="language-"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'source_code_box_padding',
            [
                'label' => __('Padding', 'docy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .docy-source-code pre' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'source_code_box_margin',
            [
                'label' => __('Margin', 'docy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .docy-source-code pre' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        wp_enqueue_style('prism');
        $source_code = $settings['source_code'];
        $theme = !empty($settings['theme']) ? $settings['theme'] : 'prism';
        $this->add_render_attribute('docy-code-wrap', 'class', 'docy-source-code');
        $this->add_render_attribute('docy-code-wrap', 'class', $theme);
        $this->add_render_attribute('docy-code-wrap', 'data-lng-type', $settings['lng_type']);
        $this->add_render_attribute('docy-code', 'class', 'language-' . $settings['lng_type']);
        ?>
        <?php if (!empty($source_code)): ?>
            <div <?php $this->print_render_attribute_string('docy-code-wrap'); ?>>
			<pre>
				<code <?php $this->print_render_attribute_string('docy-code'); ?>>
					<?php echo esc_html($source_code); ?>
				</code>
			</pre>
            </div>
        <?php endif; ?>
        <?php

    }

}
