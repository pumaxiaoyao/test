<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit07e4f559cdb55a9d6e219e6b065db4c1
{
    public static $files = array (
        'e1edc6b39e340029dfa1d72c228b8497' => __DIR__ . '/..' . '/xiaoler/blade/src/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'X' => 
        array (
            'Xiaoler\\Blade\\' => 14,
        ),
        'W' => 
        array (
            'Whoops\\' => 7,
        ),
        'S' => 
        array (
            'Symfony\\Component\\Finder\\' => 25,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'G' => 
        array (
            'Gregwar\\' => 8,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Xiaoler\\Blade\\' => 
        array (
            0 => __DIR__ . '/..' . '/xiaoler/blade/src',
        ),
        'Whoops\\' => 
        array (
            0 => __DIR__ . '/..' . '/filp/whoops/src/Whoops',
        ),
        'Symfony\\Component\\Finder\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/finder',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Gregwar\\' => 
        array (
            0 => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'App\\Config\\Config' => __DIR__ . '/../..' . '/app/Config/Config.php',
        'App\\Controllers\\ActivityStatus' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\AgentAPIController' => __DIR__ . '/../..' . '/app/Controllers/AgentAPIController.php',
        'App\\Controllers\\AgentController' => __DIR__ . '/../..' . '/app/Controllers/AgentController.php',
        'App\\Controllers\\AgentRecordBalanceType' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\AgentStatus' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\BankCardStatus' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\BaseController' => __DIR__ . '/../..' . '/app/Controllers/BaseController.php',
        'App\\Controllers\\CheckStatus' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\CommonAPIController' => __DIR__ . '/../..' . '/app/Controllers/CommonAPIController.php',
        'App\\Controllers\\GameAPIController' => __DIR__ . '/../..' . '/app/Controllers/GameAPIController.php',
        'App\\Controllers\\GameController' => __DIR__ . '/../..' . '/app/Controllers/GameController.php',
        'App\\Controllers\\HelpController' => __DIR__ . '/../..' . '/app/Controllers/HelpController.php',
        'App\\Controllers\\JointType' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\MessageStatus' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\PlatformType' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\PlayerAPIController' => __DIR__ . '/../..' . '/app/Controllers/PlayerAPIController.php',
        'App\\Controllers\\PlayerController' => __DIR__ . '/../..' . '/app/Controllers/PlayerController.php',
        'App\\Controllers\\PlayerRecordBalanceType' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\PlayerRecordLoginType' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\PlayerStatus' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\RateType' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Controllers\\SettleStatementStatus' => __DIR__ . '/../..' . '/app/Controllers/Def.php',
        'App\\Core\\Route\\Route' => __DIR__ . '/../..' . '/app/Core/Route.php',
        'App\\Core\\View' => __DIR__ . '/../..' . '/app/Core/view.php',
        'App\\Libs\\GeetestLib' => __DIR__ . '/../..' . '/app/Libs/GeetestLib.php',
        'App\\Libs\\HttpRequest' => __DIR__ . '/../..' . '/app/Libs/HttpRequest.php',
        'App\\Libs\\HttpResponse' => __DIR__ . '/../..' . '/app/Libs/HttpResponse.php',
        'Gregwar\\Captcha\\CaptchaBuilder' => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar/Captcha/CaptchaBuilder.php',
        'Gregwar\\Captcha\\CaptchaBuilderInterface' => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar/Captcha/CaptchaBuilderInterface.php',
        'Gregwar\\Captcha\\ImageFileHandler' => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar/Captcha/ImageFileHandler.php',
        'Gregwar\\Captcha\\PhraseBuilder' => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar/Captcha/PhraseBuilder.php',
        'Gregwar\\Captcha\\PhraseBuilderInterface' => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar/Captcha/PhraseBuilderInterface.php',
        'Psr\\Log\\AbstractLogger' => __DIR__ . '/..' . '/psr/log/Psr/Log/AbstractLogger.php',
        'Psr\\Log\\InvalidArgumentException' => __DIR__ . '/..' . '/psr/log/Psr/Log/InvalidArgumentException.php',
        'Psr\\Log\\LogLevel' => __DIR__ . '/..' . '/psr/log/Psr/Log/LogLevel.php',
        'Psr\\Log\\LoggerAwareInterface' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerAwareInterface.php',
        'Psr\\Log\\LoggerAwareTrait' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerAwareTrait.php',
        'Psr\\Log\\LoggerInterface' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerInterface.php',
        'Psr\\Log\\LoggerTrait' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerTrait.php',
        'Psr\\Log\\NullLogger' => __DIR__ . '/..' . '/psr/log/Psr/Log/NullLogger.php',
        'Psr\\Log\\Test\\DummyTest' => __DIR__ . '/..' . '/psr/log/Psr/Log/Test/LoggerInterfaceTest.php',
        'Psr\\Log\\Test\\LoggerInterfaceTest' => __DIR__ . '/..' . '/psr/log/Psr/Log/Test/LoggerInterfaceTest.php',
        'Symfony\\Component\\Finder\\Comparator\\Comparator' => __DIR__ . '/..' . '/symfony/finder/Comparator/Comparator.php',
        'Symfony\\Component\\Finder\\Comparator\\DateComparator' => __DIR__ . '/..' . '/symfony/finder/Comparator/DateComparator.php',
        'Symfony\\Component\\Finder\\Comparator\\NumberComparator' => __DIR__ . '/..' . '/symfony/finder/Comparator/NumberComparator.php',
        'Symfony\\Component\\Finder\\Exception\\AccessDeniedException' => __DIR__ . '/..' . '/symfony/finder/Exception/AccessDeniedException.php',
        'Symfony\\Component\\Finder\\Finder' => __DIR__ . '/..' . '/symfony/finder/Finder.php',
        'Symfony\\Component\\Finder\\Glob' => __DIR__ . '/..' . '/symfony/finder/Glob.php',
        'Symfony\\Component\\Finder\\Iterator\\CustomFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/CustomFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\DateRangeFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/DateRangeFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\DepthRangeFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/DepthRangeFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\ExcludeDirectoryFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/ExcludeDirectoryFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\FileTypeFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/FileTypeFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\FilecontentFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/FilecontentFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\FilenameFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/FilenameFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\MultiplePcreFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/MultiplePcreFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\PathFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/PathFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\RecursiveDirectoryIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/RecursiveDirectoryIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\SizeRangeFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/SizeRangeFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\SortableIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/SortableIterator.php',
        'Symfony\\Component\\Finder\\SplFileInfo' => __DIR__ . '/..' . '/symfony/finder/SplFileInfo.php',
        'Whoops\\Exception\\ErrorException' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Exception/ErrorException.php',
        'Whoops\\Exception\\Formatter' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Exception/Formatter.php',
        'Whoops\\Exception\\Frame' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Exception/Frame.php',
        'Whoops\\Exception\\FrameCollection' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Exception/FrameCollection.php',
        'Whoops\\Exception\\Inspector' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Exception/Inspector.php',
        'Whoops\\Handler\\CallbackHandler' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Handler/CallbackHandler.php',
        'Whoops\\Handler\\Handler' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Handler/Handler.php',
        'Whoops\\Handler\\HandlerInterface' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Handler/HandlerInterface.php',
        'Whoops\\Handler\\JsonResponseHandler' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Handler/JsonResponseHandler.php',
        'Whoops\\Handler\\PlainTextHandler' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Handler/PlainTextHandler.php',
        'Whoops\\Handler\\PrettyPageHandler' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Handler/PrettyPageHandler.php',
        'Whoops\\Handler\\XmlResponseHandler' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Handler/XmlResponseHandler.php',
        'Whoops\\Run' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Run.php',
        'Whoops\\RunInterface' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/RunInterface.php',
        'Whoops\\Util\\HtmlDumperOutput' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Util/HtmlDumperOutput.php',
        'Whoops\\Util\\Misc' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Util/Misc.php',
        'Whoops\\Util\\SystemFacade' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Util/SystemFacade.php',
        'Whoops\\Util\\TemplateHelper' => __DIR__ . '/..' . '/filp/whoops/src/Whoops/Util/TemplateHelper.php',
        'Xiaoler\\Blade\\Autoloader' => __DIR__ . '/..' . '/xiaoler/blade/src/Autoloader.php',
        'Xiaoler\\Blade\\Compilers\\BladeCompiler' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/BladeCompiler.php',
        'Xiaoler\\Blade\\Compilers\\Compiler' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Compiler.php',
        'Xiaoler\\Blade\\Compilers\\CompilerInterface' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/CompilerInterface.php',
        'Xiaoler\\Blade\\Compilers\\Concerns\\CompilesComments' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Concerns/CompilesComments.php',
        'Xiaoler\\Blade\\Compilers\\Concerns\\CompilesComponents' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Concerns/CompilesComponents.php',
        'Xiaoler\\Blade\\Compilers\\Concerns\\CompilesConditionals' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Concerns/CompilesConditionals.php',
        'Xiaoler\\Blade\\Compilers\\Concerns\\CompilesEchos' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Concerns/CompilesEchos.php',
        'Xiaoler\\Blade\\Compilers\\Concerns\\CompilesIncludes' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Concerns/CompilesIncludes.php',
        'Xiaoler\\Blade\\Compilers\\Concerns\\CompilesInjections' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Concerns/CompilesInjections.php',
        'Xiaoler\\Blade\\Compilers\\Concerns\\CompilesLayouts' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Concerns/CompilesLayouts.php',
        'Xiaoler\\Blade\\Compilers\\Concerns\\CompilesLoops' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Concerns/CompilesLoops.php',
        'Xiaoler\\Blade\\Compilers\\Concerns\\CompilesRawPhp' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Concerns/CompilesRawPhp.php',
        'Xiaoler\\Blade\\Compilers\\Concerns\\CompilesStacks' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Concerns/CompilesStacks.php',
        'Xiaoler\\Blade\\Compilers\\Concerns\\CompilesTranslations' => __DIR__ . '/..' . '/xiaoler/blade/src/Compilers/Concerns/CompilesTranslations.php',
        'Xiaoler\\Blade\\Concerns\\ManagesComponents' => __DIR__ . '/..' . '/xiaoler/blade/src/Concerns/ManagesComponents.php',
        'Xiaoler\\Blade\\Concerns\\ManagesLayouts' => __DIR__ . '/..' . '/xiaoler/blade/src/Concerns/ManagesLayouts.php',
        'Xiaoler\\Blade\\Concerns\\ManagesLoops' => __DIR__ . '/..' . '/xiaoler/blade/src/Concerns/ManagesLoops.php',
        'Xiaoler\\Blade\\Concerns\\ManagesStacks' => __DIR__ . '/..' . '/xiaoler/blade/src/Concerns/ManagesStacks.php',
        'Xiaoler\\Blade\\Contracts\\Arrayable' => __DIR__ . '/..' . '/xiaoler/blade/src/Contracts/Arrayable.php',
        'Xiaoler\\Blade\\Contracts\\Renderable' => __DIR__ . '/..' . '/xiaoler/blade/src/Contracts/Renderable.php',
        'Xiaoler\\Blade\\Debug\\Exception\\ClassNotFoundException' => __DIR__ . '/..' . '/xiaoler/blade/src/Debug/Exception/ClassNotFoundException.php',
        'Xiaoler\\Blade\\Debug\\Exception\\FatalErrorException' => __DIR__ . '/..' . '/xiaoler/blade/src/Debug/Exception/FatalErrorException.php',
        'Xiaoler\\Blade\\Debug\\Exception\\FatalThrowableError' => __DIR__ . '/..' . '/xiaoler/blade/src/Debug/Exception/FatalThrowableError.php',
        'Xiaoler\\Blade\\Debug\\Exception\\FlattenException' => __DIR__ . '/..' . '/xiaoler/blade/src/Debug/Exception/FlattenException.php',
        'Xiaoler\\Blade\\Debug\\Exception\\OutOfMemoryException' => __DIR__ . '/..' . '/xiaoler/blade/src/Debug/Exception/OutOfMemoryException.php',
        'Xiaoler\\Blade\\Debug\\Exception\\SilencedErrorContext' => __DIR__ . '/..' . '/xiaoler/blade/src/Debug/Exception/SilencedErrorContext.php',
        'Xiaoler\\Blade\\Debug\\Exception\\UndefinedFunctionException' => __DIR__ . '/..' . '/xiaoler/blade/src/Debug/Exception/UndefinedFunctionException.php',
        'Xiaoler\\Blade\\Debug\\Exception\\UndefinedMethodException' => __DIR__ . '/..' . '/xiaoler/blade/src/Debug/Exception/UndefinedMethodException.php',
        'Xiaoler\\Blade\\Debug\\FatalErrorHandler\\ClassNotFoundFatalErrorHandler' => __DIR__ . '/..' . '/xiaoler/blade/src/Debug/FatalErrorHandler/ClassNotFoundFatalErrorHandler.php',
        'Xiaoler\\Blade\\Debug\\FatalErrorHandler\\UndefinedFunctionFatalErrorHandler' => __DIR__ . '/..' . '/xiaoler/blade/src/Debug/FatalErrorHandler/UndefinedFunctionFatalErrorHandler.php',
        'Xiaoler\\Blade\\Debug\\FatalErrorHandler\\UndefinedMethodFatalErrorHandler' => __DIR__ . '/..' . '/xiaoler/blade/src/Debug/FatalErrorHandler/UndefinedMethodFatalErrorHandler.php',
        'Xiaoler\\Blade\\Engines\\CompilerEngine' => __DIR__ . '/..' . '/xiaoler/blade/src/Engines/CompilerEngine.php',
        'Xiaoler\\Blade\\Engines\\Engine' => __DIR__ . '/..' . '/xiaoler/blade/src/Engines/Engine.php',
        'Xiaoler\\Blade\\Engines\\EngineInterface' => __DIR__ . '/..' . '/xiaoler/blade/src/Engines/EngineInterface.php',
        'Xiaoler\\Blade\\Engines\\EngineResolver' => __DIR__ . '/..' . '/xiaoler/blade/src/Engines/EngineResolver.php',
        'Xiaoler\\Blade\\Engines\\FileEngine' => __DIR__ . '/..' . '/xiaoler/blade/src/Engines/FileEngine.php',
        'Xiaoler\\Blade\\Engines\\PhpEngine' => __DIR__ . '/..' . '/xiaoler/blade/src/Engines/PhpEngine.php',
        'Xiaoler\\Blade\\Factory' => __DIR__ . '/..' . '/xiaoler/blade/src/Factory.php',
        'Xiaoler\\Blade\\FileViewFinder' => __DIR__ . '/..' . '/xiaoler/blade/src/FileViewFinder.php',
        'Xiaoler\\Blade\\Filesystem' => __DIR__ . '/..' . '/xiaoler/blade/src/Filesystem.php',
        'Xiaoler\\Blade\\Support\\Arr' => __DIR__ . '/..' . '/xiaoler/blade/src/Support/Arr.php',
        'Xiaoler\\Blade\\Support\\HtmlString' => __DIR__ . '/..' . '/xiaoler/blade/src/Support/HtmlString.php',
        'Xiaoler\\Blade\\Support\\Str' => __DIR__ . '/..' . '/xiaoler/blade/src/Support/Str.php',
        'Xiaoler\\Blade\\View' => __DIR__ . '/..' . '/xiaoler/blade/src/View.php',
        'Xiaoler\\Blade\\ViewFinderInterface' => __DIR__ . '/..' . '/xiaoler/blade/src/ViewFinderInterface.php',
        'Xiaoler\\Blade\\ViewName' => __DIR__ . '/..' . '/xiaoler/blade/src/ViewName.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit07e4f559cdb55a9d6e219e6b065db4c1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit07e4f559cdb55a9d6e219e6b065db4c1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit07e4f559cdb55a9d6e219e6b065db4c1::$classMap;

        }, null, ClassLoader::class);
    }
}