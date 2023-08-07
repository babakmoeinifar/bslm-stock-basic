@extends(isStockholderAndLeft() ? 'template.master-stockholder-left-user' : 'template.master-user')

@section('title', 'همه چیز درباره مثقال و ESOP باسلام')

@section('content')
    @include('template.messages')
    
    <div class="card ss02">
        <div class="card-content">

            <div class="card-body">

                <h1 class="mb-5">همه چیز درباره مثقال و ESOP باسلام</h1>
                <p>چی بهتر از این که ما روی چیزی کار کنیم که متعلق به خودمونه؟</p>
                <p>برای گروهی از افراد، جذاب‌ترین شکل عواید مالی، حقوق ماهانه نیست. این هست که در منافع رشد شرکت سهیم باشن، حتی اگر نقد شدن این منافع نیاز به صبر طولانی‌مدت داشته باشه. قرارداد ESOP که مخفف Employee Stock Ownership Plan هست، بدون نیاز به ریسک سرمایه‌گذاری با پول مستقیم، امکان شریک شدن در منافع شرکت رو برای اعضا فراهم می‌کنه. در عین حال، برای شرکت هم این فایده رو داره که اعضا انگیزه‌ی قدرتمندی برای عملکرد عالی و بلندمدت به دست میارن و به تبع شرکت بیشتر رشد می‌کنه و هر چه شرکت بیشتر رشد کنه، باز اون انگیز‌ه‌های انسانی برای عملکرد درخشان‌تر بیشتر هم می‌شه! پس با یک positive reinforcement loop مواجهیم که تمام ذی‌نفع‌ها از بودن در این چرخه‌ی تعالی خشنود خواهند بود.</p>
                <p>ایده‌ی تسهیم حداکثری منافع از ابتدای باسلام وجود داشت. برخلاف جریان معمول، تعداد هم‌بنیان‌گذاران باسلام از ابتدا زیاد بود. در سال ۹۸ تعداد سهام‌داران قدری بیشتر شد و از سال ۱۴۰۰ دعوت به جمع سهام‌داری سرعت بیشتری گرفت. باسلام خوشحال است که فرصت دعوت از افراد بیشتری برای سهام‌داری فراهم شده و این مسیر را برای چند سال محدود با سرعتی بیش‌تر از همیشه ادامه خواهد داد.</p>
                
                <h3 class="mt-5">قرارداد esop چیه؟</h3 class="mt-5">
                <p>قراردادی هست که به موجب اون، طبق شرایط عملکردی و زمانی مشخصی، بخشی از مثقال‌های شرکت به عضوی از شرکت واگذار می‌شه. قراردادهای esop شما، هم به صورت فیزیکی از طرف شرکت تقدیم‌تون می‌شه، هم در اینجا آخرین وضعیت و ارزش‌اش رو می‌تونید ببینید.</p>
                <p><b>قرارداد esop دو جوره:</b></p>
                <b>۱) اعطای اختیار خرید سهام (Option to Purchase) به کارکنان یا همون Stock Option</b>
                <p>در این حالت، تحت شرایط معینی به اعضای شرکت اختیار و حق خرید سهام شرکت به قیمت کمتری از قیمت بازار اعطا می‌شه. و اون شخص می‌تونه با پرداخت مبلغ مناسبی که گاهاً از حقوقش کسر می‌شه، سهام شرکت را بخره. چنین مدلی رو فعلا در باسلام نداریم اما ممکنه در آینده اضافه کنیم.</p>

                <p><b>۲) مدل باسلام: اعطای بلاعوض مثقال</b></p>
                <p>در این حالت بدون نیاز به پرداخت پولی از طرف عضو، مثقال‌ها به رایگان به ایشون اعطا می‌شه  ولی مالکیت‌اش قطعی نمی‌شه تا شرایط vesting (واگذاری) محقق بشه. در زمان تحقق شرایط واگذاری، علاوه بر تقدیم قرارداد فیزیکی، مثقال‌ها از سبد «مثقال‌های آینده» کاسته و به سبد «مثقال‌های من» منتقل می‌شه.</p>
                <p>وقتی که شرکت IPO بشه و بره بورس، مثقال‌ها تبدیل به سهام‌های بورسی می‌شن و خرید و فروش اون‌ها به سادگی تمام در اختیار مالک‌اش قرار می‌گیره. تا پیش از IPO جاده‌ی عریضی برای فروش مقیاس بالایی از این مثقال‌ها توسط اعضا، تقریبا نیست، به جز مقادیر کنترل شده‌ای که ممکنه تحت شرایط خاصی مثل جذب سرمایه با موافقت هیئت مدیره امکان‌پذیر باشه یا از طریق معامله مثقال بین اعضا اتفاق بیفته.</p>

                <h3 class="mt-5">مثقال چیه و چطور کار می‌کنه؟</h3 class="mt-5">
                <p>به جای کلمه سهام، از «مثقال» استفاده می‌کنیم. وجه تسمیه مثقال، مفهوم ذره‌ی کوچکی هست که بسیار ارزشمنده و طلا و نقره رو به ذهن متبادر می‌کنه. ما ارزش باسلام رو به هزاران مثقال تبدیل کردیم؛ در سال ۱۳۹۵ ارزش هر مثقال ۱۰۰ تومن بود و در ابتدای ۱۴۰۱ این ارزش به دلیل رشد ارزش شرکت تا ۴۰ برابر رشد کرد.</p>
                <ul>
                    <li>تعداد مثقال‌های باسلام با تزریق سرمایه بیشتر می‌شه. به این معنا که پشتوانه‌ی هر مثقال، پولی هست که به شرکت به شکل واقعی وارد شده.</li>
                    <li>ارزش هر مثقال بر اساس ارزش‌گذاری کل شرکت تقسیم بر تعداد مثقال‌ها به دست میاد. ارزش‌گذاری شرکت هم بر اساس انواع دارایی‌های اون شامل مشهود و غیرمشهود، نقدی و غیر‌نقدی توسط شرکت‌های تخصصی ارزش‌گذاری تخمین زده می‌شه. این ارزش در بخش ارزش روز مثقال قابل مشاهده هست.</li>
                </ul>

                <p>اگر شما مالک ۱۰۰ هزار مثقال از ۲۰۰ میلیون مثقال باسلام باشید، مشخصه که مالک چند درصد از باسلام هستید. پس‌فردا که قرار شد مثقال‌های شما در زمان IPO به برگه سهام بورسی تبدیل بشه، کاملا روشنه که شما باید مالک چند برگ سهام بورسی باسلام بشید. در اون زمان درصد مالکیت شما ضرب در آخرین ارزش‌گذاری رسمی باسلام هنگام ورود به بورس خواهد شد.</p>

                <h3 class="mt-5">مثقال‌ها تحت چه شرایطی به اعضا واگذار می‌شه؟</h3 class="mt-5">

                <p>
                    <b>۱. شرط زمان:</b>
                    توی این قراردادی که به ازای هر سال با اعضا امضا می‌شه، مثقال‌های قرارداد معمولا طی یک دوره سه‌ساله واگذار می‌شه. دو سال اول که بهش «cliff» می‌گن، هیچ بخشی از مثقال‌ها واگذار نمی‌شه و اگه همکاری شما قبل از اون به پایان برسه، مثقال‌های اون قرارداد کأن لم یکن می‌شه.
                </p>
                <p>ولی در صورت ادامه همکاری، در پایان سال دوم ۵۰ درصد و در پایان سال سوم ۱۰۰ درصد مثقال‌های شما واگذار می‌شه و شما از مزایای اون بهره‌مند می‌شید. مثلا حتی پیش از ورود به بورس اگه باسلام بتونه مبلغی رو به عنوان سود شرکت شناسایی کنه که قرار باشه بین مثقال‌داران تقسیم بشه، اگه تراز مالی شرکت مثبت بشه، زیان انباشته‌ای نباشه، برنامه‌ی توسعه‌ای وجود نداشته باشه و هیئت مدیره و مجمع سهام‌داران صاحب امضا موافق باشند، شما هم به میزان مثقالی که دارید، از اون سود دریافت می‌کنید.</p>

                <p>
                    <b>۲. شروط عملکردی:</b>
                    تا مرداد ماه ۱۴۰۱، قرارداد esop باسلام با همه اعضای شرکت بسته نشده و فقط برای جایگاه‌های با عملکرد کلیدی در نظر گرفته شده. اما جهت‌گیری کلی باسلام اینه که با سرعت خوبی به تعداد این قراردادها اضافه بشه و جمع بیشتری از اعضای شرکت، مثقال‌دار بشن. ایده‌آل دوری که بهش فکر می‌کنیم این هست که تمام اعضای باسلام به تناسب درستی مثقال‌دار باشن.
                </p>

                <p>طبق قرادادی که با شما بسته شده، رضایت تیم از عملکرد شما در واگذاری مثقال‌ها اهمیت داره. فرضا اگه کسی به شرکت آسیبی بزنه یا شرایطی پیش بیاد که باسلام تصمیم به پایان همکاری ایشون بگیره، در قرارداد قید شده که طبق تصمیم هیئت مدیره، امکان لغو یک‌طرفه قرارداد esop وجود داره؛ حتی بعد از اینکه مثقال‌ها به طور کامل واگذار شده.</p>

                <p>همچنین ارزش مثقالی که با افتخار تقدیم شما می‌شود برای سرمایه‌گذاران، هم‌بنیان‌گذاران و مثقال‌داران شرکت ارزش قابل اعتنایی است. بر اساس تصمیم و توافق این جمع، یکی از شروط لازم واگذاری مثقال‌ها، تمرکز کاری عالی بر ماموریت در باسلام است. بنابرین باسلام مثقال‌های با مقیاس قابل توجه را به افرادی که تمام تمرکز خود را به باسلام معطوف نکرده‌اند، واگذار نمی‌کند.</p>

                <p>
                    <b>۳. شروط واگذاری و انتقال به غیر:</b>
                    همون‌طور که بالاتر ذکر شد، پیش از واگذار شدن مثقال‌های شما که اصلا امکان انتقالش نیست؛ چون شما هنوز مالک‌اش نشدید. بعد از واگذاری کامل مثقال هم، فروش و انتقالش به غیر، همچنان منوط به تأیید هیئت مدیره است. ولی بعد از تبدیل شدن باسلام به سهامی عام، شما کنترل صددرصدی و بدون قید و شرط روی سهام خودتون خواهید داشت. 
                </p>

                <h3 class="mt-5">چرا esop به جای درصد، به شکل ریالی اعطا می‌شه؟</h3 class="mt-5">
                <p>به خاطر ساده‌سازی مفهوم. اگر به قرارداد esop خودتون دقت کرده باشید، معادل ریالی پیشنهاد مثقال به شما اعلام شده. یعنی مثلا به جای اینکه به شما گفته بشه شما مالک ۰.۰۱٪ باسلام هستید، نوشته شده که در ارزش‌گذاری مثلا ۲۰۰ میلیارد تومانی باسلام، برای سال ۱۳۹۸ به شما مبلغ ۲۰۰ میلیون تومان esop اعطا شده. حالا اگه در مقطع جذب سرمایه بعدی، مبلغ سنگینی سرمایه وارد باسلام بشه و باسلام افزایش سرمایه بده، درصد مالکیت شما نسبت به کل کاهش پیدا می‌کنه، ولی در عین حال،‌ ارزش دارایی شما هم رشد می‌کنه. چون به واسطه اون جذب سرمایه و عملکرد شرکت، ارزش کلی شرکت به رقم بالاتری رسیده. به این فرایند کاهش درصد سهام شما dilution گفته می‌شه که می‌تونین درباره‌ش گوگل کنین. ولی عجالتا برای خروج از این پیچیدگی‌ها به جای درصد، از مثقال که معادل ریالی داره استفاده می‌شه. در این حالت با ورود سرمایه‌گذارهای جدید هیچ وقت تعداد مثقال شما کم نمی‌شه و همیشه به سادگی از ضرب تعداد مثقال در ارزش هر مثقال داریی روز خودتون رو می‌تونید مشاهده کنید.</p>

                <h3 class="mt-5">هر سال esop خودش رو داره</h3 class="mt-5">
                <p>یه چیز دیگه‌ای که توی بخش سهام می‌بینید، وضعیت قراردادهای هر سال esop خودتونه. چون قرارداد هر سالی با قراردادهای سال‌های دیگه متفاوته. برای همین ممکنه قرارداد اولین سال esop شما الان کامل واگذار شده باشه، ولی مثلا سال بعدش تازه ۵۰ درصدش واگذار شده باشه و سال بعدترش اصلا واگذار نشده باشه. اینا رو هم می‌تونین از اینجا ببینید. </p>
                <p>یک مثال: اگه شما از سال ۹۸ تا ۱۴۰۱، هر چهار سال متوالی از باسلام esop دریافت کرده باشید و مثلا همکاری شما با باسلام در شهریور ۱۴۰۱ به پایان برسه، شما مالک کل مثقالز هستید که برای سال ۹۸ دریافت کردید، ۵۰ درصد از مثقال‌های سال ۹۹ رو هم مالک شدید. ولی مثقال‌های سال ۱۴۰۰ شما کأن لم یکن می‌شه و با رفتن‌تون از باسلام،‌ اون رو از دست می‌دین. جزئیات وضعیت واگذاری مثقال‌هاتون رو هم می‌تونین توی بخش سهام در باسلامی‌ها ببینید.</p>

                <p><img class="img-fluid w-70" src="/storage/avatar/stock-chart.png"/></p>


                <h3 class="mt-5">کی وارد بورس می‌شیم؟</h3 class="mt-5">
                <p>وقتی که:</p>
                <ul>
                    <li>حداقل یک سال تراز مالی مثبت داشته باشیم.</li>
                    <li>کارشناس معتمد بورس حسابرسی کرده باشه باسلام رو.</li>
                    <li>ارزش‌گذاری شرکت توسط شرکت‌های ارزیاب معتمد بورس انجام شده باشه.</li>
                </ul>
                <p>قسمت سختش مورد اوله.</p>
                <p>فارغ از بورس، در صورت نیاز به جذب سرمایه‌، تمایل و فکر باسلام به این سمت هست که طبق اولویت، برای غرفه‌ها و مشتریان ممتاز باسلام امکان سرمایه‌گذاری در باسلام رو فراهم کنه.</p>

                <h3 class="mt-5">آیا esop ریسکی داره؟</h3 class="mt-5">
                <p>به شکلی که سرمایه‌گذارها یا هم‌بنیان‌گذارها ریسک دارن نه. یعنی در صورت شکست خوردن شرکت تعهدات مالی‌ای برای مثقال‌داران وجود نخواهد داشت. اما ریسک مثقال‌دارها اینه که زمانی که می‌ذارن اون منفعت بزرگ بالقوه رو بالفعل نکنه. که خب البته برای همه ما بسیار جذابه که تلاش کنیم ارزش مثقال‌هامون ده برابر و صد برابر بشه و سعی می‌کنیم این ریسک پررنگ نشه.</p>

                <h3 class="mt-5">مثقال‌دار بودن با نبودن چه فرقی داره؟</h3 class="mt-5">

                <p>فرقش اینه که دیگه صرفا در استخدام شرکت نیستیم و خودمون صاحب‌خونه هستیم. انگیزه‌های ما برای موفقیت باسلام یک سطح بالاتر قرار می‌گیره و هر کدوم از ما اصلاح‌کننده و بهبوددهنده‌ی شرکت در هر وجهی خواهیم بود. بسیاری از مشکلاتی که در حالت عادی به عنوان یک نیرو ممکنه باهاش مواجه باشیم، در زمان مثقال‌داری تبدیل می‌شه به یک مساله که باید به هم کمک کنیم تا حل بشه و خیلی از چالش‌های پرهزینه و طولانی به مسائل ساده‌ی زودحل‌شونده تقلیل پیدا می‌کنه.</p>

                <p>بسیار خوشحالیم که باسلام داره شرکا و ذی‌نفعان بیشتری پیدا می‌کنه و بسیار امیدواریم که  این ذی‌نفعی یا skin in the game نتایج درخشانی بسازه.</p>
            </div>
        </div>
    </div>
    
@endsection
