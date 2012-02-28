<?php
// RafCloud rus v0.9
// Автор: Сергей Романчук
// rezety@gmail.com
define( "RC_WORDS", "Тэги" );
define( "RC_PUBLISHED", "Опубликованные" );
define( "RC_COUNTER", "Повторений(раз)" );
define( "RC_FONTSIZE", "Размер шрифта (%)" );
define( "RC_SETTINGS", "Raf Cloud настройки." );
define( "RC_PARAMETERS", "Параметры:" );
define( "RC_CONFIG_UNWRITABLE", "Ошибка записи в settings.php" );
define( "RC_MSG_REMEMBER", "Проверьте все настройки, а затем, после сохранения, нажмите \"Перезагрузить список\".<br> <br>Не забудьте установить и настроить <a target=\"_blank\" href=\"http://www.joomla.royy.net/index.php/Download-document/42-Raf-Cloud-Module.html\" >Raf Cloud модуль </a>" );
define( "RC_CONFIGURATION", "Настройки" );
define( "RC_DEFAULT_PUBLISHED", "Автопубликация слов:" ); 
define( "RC_DEFAULT_PUBLISHED_DES", "Все новые слова будут опубликованы" );
define( "RC_SAVED", "Конфигурация была сохранена" ); 
define( "RC_DEFAULT_MIN_COUNTER", "Минимальное кол-во повторений" ); 
define( "RC_DEFAULT_MIN_COUNTER_DES", "Слова, встречающиеся чаще, чем установленное значение, будут добавлены в список." );
define( "RC_DEFAULT_MIN_LEN", "Минимальная длина слова" );
define( "RC_DEFAULT_MIN_LEN_DES", "Слова с большим количеством символов, чем установлено, будут добавлены в список" ); //=
define( "RC_DEFAULT_MAX_LEN", "Максимальная длина слова" );
define( "RC_DEFAULT_MAX_LEN_DES", "Слова с меньшим количеством символов, чем установлено, будут добавлены в список.(макс.200)" ); //=
define( "RC_DEFAULT_MIN_FONT", "Минимальный размер шрифта (%)" );
define( "RC_DEFAULT_MIN_FONT_DES", "Должен быть больше 0, но не равен максимальному." );
define( "RC_DEFAULT_MAX_FONT", "Максимальный размер шрифта (%)" );
define( "RC_DEFAULT_MAX_FONT_DES", "Должен быть больше чем минимальный." );
define( "RC_YES", "Да" );
define( "RC_NO", "Нет" );
define( "RC_CONFIG", "Конфигурация" );
define( "RC_BUILD", "Перезагрузить список" );
define( "RC_ERASE", "Удалить" );
define( "RC_ERASE_DES", "Чтобы удалить все тэги, выберите один из списка и нажмите \"Удалить все\"." );
define( "RC_ERASE_ALL", "Удалить все" );
define( "RC_ERASE_UNPUBL", "Удалить неопубликованные" );
define( "RC_ERASE_SELECTED", "Удалить выбранные" );
define( "RC_ADDED", "Добавлено" );
define( "RC_WORD_LENGHT", "Длина" );
define( "RC_WORD_LIST", "Список тэгов" );
define( "RC_DEFAULT_BLACKLIST", "Черный список" ); 
define( "RC_DEFAULT_BLACKLIST_DES", "Перечисленные слова должны разделяться запятой." );
define( "RC_DEFAULT_BLACKLIST_WORDS", "о,
об,
на,
и,
ибо,
ахтунг,
не,
а,
в,
с,
к,
со,
до,
сих,
пор,
на,
но,
из,
бы,
ты,
мы,
вы,
я,
йа,
они,
все,
всё,
нам,
им,
сам,
себя,
их,
вас,
Вас,
вам,
Вам,
всем,
его,
ему,
ей,
тот,
этот,
другой,
вне,
вон,
где,
зачем,
как,
какой,
каков,
когда,
который,
кто,
куда,
откуда,
почему,
сколько,
чей,
чем,
чему,
кем,
почему,
что,
там,
верх,
низ,
бок,
снизу,
сверху,
вниз,
вверх,
налево,
направо,
север,
запад,
восток,
юг,
северо-запад,
северо-восток,
юго-запад,
юго-восток,
вбок,
право,
лево,
далеко,
близко,
далека,
поперек,
поперёк,
сквозь,
через,
поверх,
почти,
близко,
далеко,
зависимо,
ясно,
понятно,
очевидно,
невероятно,
постоянно,
незаметно,
моментально,
совершенно,
категорически,
особенно,
безуспешно,
безвольно,
ненаглядно,
ненаглядная,
ненаглядный,
безобразие,
безолаберность,
вообще,
везде,
здесь,
всегда,
общем,
против,
за,
перед,
после,
снова,
опять,
почти,
протяжение,
протяжении,
один,
два,
три,
четрые,
пять,
шесть,
семь,
восемь,
девять,
десять,
сантиметр,
дециметр,
метр,
миллиметр,
километр,
литр,
добро,
пожаловать,
привет,
здавствуйте,
здорова,
приветствую,
свидание,
свидания,
прощай,
прощайте,
бб,
старт,
стоп,
конец,
начало,
первый,
второй,
третий,
четвертый,
пятый,
шестой,
седьмой,
восьмой,
девятый,
десятый,
первая,
вторая,
третья,
четвертая,
пятая,
шестая,
седьмая,
восьмая,
девятая,
десятая,
первое,
второе,
третье,
четвертое,
пятое,
шестое,
седьмое,
восьмое,
девятое,
десятое,
во-первых,
во-вторых,
в-третьих,
в-четвертых,
в-пятых,
всегда,
никогда,
едва-едва,
чуть-чуть,
почти,
сижу,
пью,
слышу,
вижу,
прыгаю,
летаю,
касаюсь,
нюхаю,
падаю,
пою,
скачу,
порчу,
сидит,
пьет,
слышит,
видит,
прыгает,
летает,
касается,
нюхает,
падает,
поет,
скачет,
портит,
сидит,
поражен,
поражена,
плюс,
минус,
умножить,
разделить,
квадрате,
кубе,
степени,
буду,
будет,
будут
был,
были,
была,
было" );
define( "RC_DEFAULT_BLACKLIST_LOAD", "<-Загрузить стандартные слова" );
define( "RC_BLACKLIST_ADD", "Добавить в черный список" );
define( "RC_OK_UPLOAD", "Файл был успешно загружен." );
define( "RC_ERROR_UPLOAD", "Ошибка чтения файла!" );
define( "RC_ERROR_UPLOAD_1", "Ошибка расширения. Доступные разрешения: " );
define( "RC_ERROR_UPLOAD_2", "Ошибка записи в файл!" );
define( "RC_UPLOAD_PLUGIN_DES", "Загрузить плагин (.php) " );
define( "RC_UPLOAD", "Сохранить" );
define( "RC_ERROR_PLUGIN", "Неверный или поврежденный файл плагина." );
define( "RC_PLUGINS", "Список плагинов" );
define( "RC_REMOVE_PLUGIN", "Удалить плагин" );
define( "RC_NEED_PLUGIN", "Нужен плагин? Посмотри на <a target=\"_blank\" href=\"http://www.joomla.royy.net\"> сайте проекта </a> или спроси на форуме.");
define( "RC_BUGS_FEATURES", "Ошибками и исправлениями делитесь на форуме <a target=\"_blank\" href=\"http://www.joomla.royy.net\"> проекта </a>." );
define( "RC_DEFAULT_RUN_PERIOD", "Запускать каждый" );
define( "RC_DEFAULT_RUN_PERIOD_DES", "" );
define( "RC_DEFAULT_RUN_DATE", "Дата и время начала (ДД-ММ-ГГГГ)" );
define( "RC_DEFAULT_LIMIT", "Предел количества тэгов для e-mail отчета" );
define( "RC_DEFAULT_LIMIT_DES", "Максимальное количество тэгов в отчете");
define( "RC_DEFAULT_ADMIN_EMAIL", "e-mail" );
define( "RC_DEFAULT_ADMIN_EMAIL_DES", "Отправить отчет о новых добавленых тэгах на указанный e-mail." );
define( "RC_TITLE_EMAIL", "Отчет компонента Raf Cloud." );
define( "RC_BODY_EMAIL", "В базу данных были добавлены следующие тэги:" );
define( "RC_FOOTER_EMAIL", "Кол-во тэгов в отчете %2, предел тэгов %1. Для того чтобы посмотреть все новые тэги зайдите в список тэгов компонета и упорядочите тэги по колонке 'Новый?'." );
define( "RC_DAYS", "День" );
define( "RC_HOURS", "Час" );
define( "RC_LAST_RUN", "Последний запуск" );
define( "RC_NEXT_RUN", "Следующий запуск" );
define( "RC_CLEAR_RUN", "Подтвердить новое время запуска" );
define( "RC_NEW", "Новый?" );
define( "RC_GENTIME", "Время генерации" );
define( "RC_DEFAULT_RUN", "Автоматическое обновление списка" );
define( "RC_DEFAULT_RUN_INFO", "<br>Чтобы использовать расписание, следующие строки должны быть вставлены до закрытия тэга &lt;/body&gt; в файле шаблона: <br>(Расширения -> Шаблоны -> Текущий шаблон -> Изменить HTML)");
define( "RC_DEFAULT_RUN_CODE", "
&lt;?php<br />
if (file_exists(JPATH_SITE.&quot;/components/com_rafcloud/rafcloud.php&quot;))
<br>{<br />
echo &quot;&lt;img src=\&quot;&quot;.\$this->baseurl.&quot;/index2.php?option=com_rafcloud\&quot; width=\&quot;0\&quot; height=\&quot;0\&quot; alt=\&quot;\&quot; /&gt;&quot;;<br />
}<br />
?>" );
define( "RC_DEBUG_MODE", "Если у вас проблема с автоматическим обновлением, то кликните на данную ссылку:" );
define( "RC_DEFAULT_PREG", "Расширеные preg_replace опции" );
define( "RC_DEFAULT_PREG_DES", "Задайте свой шаблон функции preg_replace. Стандартно: <b>/[,.\-:><()!?\\n\"'{}]/</b><br> В случае возникновения проблем побробуйте:<b> /[^a-zA-Z0-9\\200-\\377]/ </b>" );
define( "RC_CONFIG_ERROR_LOCK", "Ошибка блокировки файла конфигурации" );
define( "RC_CLOSE", "Закрыть" );

define( "RC_DEFAULT_WHITELIST", "Белый список:" );
define( "RC_DEFAULT_WHITELIST_DES", "Слова должны быть разделены запятыми. Публикуются автоматически." );

define( "RC_DEFAULT_STRTOLOWER", "Функция нижнего регистра (Lower-case):" );
define( "RC_DEFAULT_STRTOLOWER_DESC", "Выберите <b>strtolower</b> только в случае проблем со специальными символами." );

define( "RC_TAB_WORDS", "Слова" );
define( "RC_TAB_KEYS", "Meta Ключи" );
define( "RC_TAB_SCHEDULER", "Расписание" );
define( "RC_TAB_TOOLS", "Инструменты" );
define( "RC_ORIGINAL", "Original" );

define( "RC_DEFAULT_ENABLE", "Загрузить слова" );
define( "RC_KEYS_ENABLE", "Загрузить ключи(ключевые слова)" );
define( "RC_KEYS_PUBLISHED", "Автопубликация ключей" );
define( "RC_KEY_MIN_COUNTER", "Минимальное кол-во повторений:" );
define( "RC_KEY_MIN_COUNTER_DES", "Ключи, встречающиеся чаще, чем установленное значение, будут добавлены в список." );
define( "RC_KEY_MIN_LEN", "Минимальная длина ключа:" );
define( "RC_KEY_MIN_LEN_DES", "Ключи с большим количеством символов, чем установлено, будут добавлены в список" );

define( "RC_KEY_MAX_LEN", "Максимальная длина ключа:" );
define( "RC_KEY_MAX_LEN_DES", "Слова с меньшим количеством символов, чем установлено, будут добавлены в список.(макс.200)" );
define( "RC_KEY_WHITELIST_DES", "Ключи должны быть разделены запятыми. Публикуются автоматически." );
define( "RC_GENERAL", "Основное" );
define( "RC_TYPE", "Тип" );


define( "RC_WORD", "Слово" );
define( "RC_KEY", "Ключ" );
define( "RC_WORD_KEY", "Слово/Ключ" );
define( "RC_W_WORD", "Слово(Белый список)" );
define( "RC_W_KEY", "Ключ(Белый список)" );

define( "RC_FILTER", "Фильтр" );
define( "RC_CANCEL", "Отменить" );
define( "RC_SAVE", "Сохранить" );

define( "RC_OLD_CONFIG", "Найден settings.php! Конфигурация загружена." );

define( "RC_KEY_PREG_DES", "Задайте свой шаблон функции preg_replace. Стандартно: <b>/[.\-:><()!?\\n\"']/</b>" );
define( "RC_KEY_ASWORD", "Разделять тэги" );
define( "RC_KEY_ASWORD_DES", "Считать тэги обычными словами." );

define( "RC_REMOVE", "Удалить базу данных RafCloud" );
define( "RC_REMOVE_DATABASE", "Удалить все таблицы RafCloud." );
define( "RC_REMOVE_ACC", "Подтвердить" );
define( "RC_REMOVED", "Таблицы были удалены, теперь удалите компонент!" );
define( "RC_ERROR", "Ошибка удаления!" );
define( "RC_ERROR_REMCONF", "Ошибка удаления settings.php!" );
define( "RC_PLUGINS_DES", "Название плагина" );
define( "RC_PLUGINS_FILE", "Файл" );
define( "RC_PLUGINS_PUBL", "Опубликованые" );

// 2.0.2

define( "RC_RUN_DEBUG", "Нажмите на это ссылку для подробной информации:" );
define( "RC_MEMUS", "Память" );
define( "RC_SEF", "ЧПУ (SEF URLs)" );
define( "RC_SH404SEFPREF", "sh404sef префикс:" );
define( "RC_SH404SEFPREF_DES", "Вы можете установить свой собственный префикс (стандартно : RC-tag). Не забудьте <b>очистить ссылки (SEF Urls)</b> в sh404sef." );
define( "RC_CACHE", "Кэширование" );
define( "RC_CACHE_DES", "Снижает нагрузку на память. (Стандартно : Да)" );

// 3.0
define( "RC_DONATION", "Если вам понравился этот компонет и хотите дальнейшего его развития, то пожалуйста поддержите нас кликом на кнопку, расположенную ниже" );

define( "RC_SH404SEFLINK", "sh404sef ссылка:" );
define( "RC_SH404SEF_WORD", "Tag (e.g.: /RC-tag/joomla.html)" );
define( "RC_SH404SEF_ID", "Index (e.g.: /RC-tag/843.html)" );
define( "RC_SH404SEF_BOTH", "Tag+Index (e.g.: /RC-tag/joomla-843.html)" );

?>