<?php
namespace App\Http\Controllers;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use Illuminate\Support\Facades\Auth;

class BotManController extends Controller
{
    protected $categories = [
        1 => '📋 Quality & Inspection',
        2 => '💰 Pricing & Payment', 
        3 => '🌾 Product Details',
        4 => '🚚 Delivery & Logistics'
    ];

    protected $questions = [
        1 => [
            1 => 'Does the paddy meet any quality certifications?'
        ],
        2 => [
            1 => 'Is the listed price negotiable?',
            2 => 'Are there any discounts for large orders?',
            3 => 'What payment methods are supported?',
            4 => 'Is full payment required at delivery?',
            5 => 'Will I get a receipt for my payment?',
            6 => 'Can I pay partially in advance?',
            7 => 'What happens if I refuse the delivery?'
        ],
        3 => [
            1 => 'What varieties of paddy are currently available?',
            2 => 'What is the standard moisture content for paddy?',
            3 => 'How is paddy quality verified?',
            4 => 'Where is the paddy sourced from?',
            5 => 'What certifications does the paddy have?'
        ],
        4 => [
            1 => 'How long will delivery take?',
            2 => 'Is delivery included in the price?',
            3 => 'Who handles delivery?'
        ]
    ];

    protected $answers = [
        1 => [
            1 => "Yes, our paddy meets Sri Lanka Standards (SLS) for milling quality."
        ],
        2 => [
            1 => "No, all prices are fixed by Fair Farm Admin based on real-time market rates to ensure fairness and transparency for both farmers and buyers.",
            2 => "Currently, no bulk discounts are offered. Prices are standardized to maintain fairness for all order sizes.",
            3 => "We only accept Cash on Delivery (COD). Payment must be made in cash when the paddy is delivered to your location.",
            4 => "Yes, 100% payment in cash is mandatory upon delivery to complete the transaction.",
            5 => "Yes, a printed or digital receipt will be provided upon payment confirmation.",
            6 => "No, Fair Farm follows a strict COD policy — full payment is collected only upon delivery.",
            7 => "Orders refused without valid reasons may incur a restocking fee, and future orders could be restricted."
        ],
        3 => [
            1 => "Available paddy varieties: Samba, Nadu, Red Raw Rice, Suwandel. Updated daily based on farmer listings.",
            2 => "Fair Farm requires 12-14% moisture content for optimal quality. All listed paddy meets this standard.",
            3 => "All paddy undergoes Fair Farm quality checks for moisture, purity, and grain integrity before listing.",
            4 => "Paddy is sourced from verified Fair Farm partner growers across Sri Lanka. Location details are shown in each listing.",
            5 => "Listed paddy meets SLS standards for milling quality. Organic certifications are marked when applicable."
        ],
        4 => [
            1 => "Delivery usually takes 2-5 business days, depending on your location.",
            2 => "Delivery charges are calculated separately based on your location. You'll see the total cost before confirming the order.",
            3 => "FairFarm's logistics team ensures safe and timely delivery after quality checks."
        ]
    ];

    /**
     * Handle incoming messages
     */
    public function handle()
    {
        $botman = app('botman');

        $this->registerConversationHandlers($botman);
        $botman->listen();
    }
    /**
     * Register all conversation handlers
     */
    protected function registerConversationHandlers(BotMan $botman)
    {
        $botman->hears('(help|questions|menu)', [$this, 'showCategoriesList']);
        $botman->hears('category_([1-4])', [$this, 'showQuestionsForCategory']);
        $botman->hears('question_([1-4])_([1-9])', [$this, 'answerSpecificQuestion']);
        $botman->hears('(hi|hello|hey)', [$this, 'handleGreeting']);
        $botman->fallback([$this, 'handleFallback']);
    }
    /**
     * Handle initial greeting
     */
    public function handleGreeting($botman)
    {
        $buyer = Auth::guard('buyer')->user();
        $buyerName = $buyer ? $buyer->FullName : '';
        $reply = "Thank you for using our website";
        if ($buyerName) {
            $reply .= " {$buyerName}";
        }
        $reply .= ". I can help answer your questions about our paddy products.";
        $botman->reply("👋 {$reply}");
        $this->showCategoriesList($botman);
    }
    /**
     * Handle unrecognized messages
     */
    public function handleFallback($botman)
    {
        $botman->reply("I'm not sure how to respond to that. Please type 'menu' to see what I can help you with.");
    }

    /**
     * Show main categories menu
     */
    public function showCategoriesList($botman)
    {
        $buttons = array_map(function ($id, $name) {
            return Button::create($name)->value("category_{$id}");
        }, array_keys($this->categories), $this->categories);

        $question = Question::create('Please choose a category:')->addButtons($buttons);

        $botman->reply($question);
    }
    /**
     * Show questions for a specific category
     */
    public function showQuestionsForCategory($botman, $categoryId)
    {
        $categoryId = (int)$categoryId;
        if (!isset($this->categories[$categoryId])) {
            $botman->reply("Please choose a valid category.");
            return $this->showCategoriesList($botman);
        }
        $botman->reply("You selected: " . $this->categories[$categoryId]);
        $buttons = array_map(function ($id, $text) use ($categoryId) {
            return Button::create($text)->value("question_{$categoryId}_{$id}");
        }, array_keys($this->questions[$categoryId]), $this->questions[$categoryId]);
        // Add back button
        $buttons[] = Button::create('↩ Back to Main Menu')->value('menu');
        $question = Question::create('Please select a question:')->addButtons($buttons);
        $botman->reply($question);
    }

    /**
     * Answer a specific question
     */
    public function answerSpecificQuestion($botman, $categoryId, $questionId)
    {
        $categoryId = (int)$categoryId;
        $questionId = (int)$questionId;

        if (!isset($this->answers[$categoryId][$questionId])) {
            $botman->reply("That question doesn't exist in this category.");
            return $this->showQuestionsForCategory($botman, $categoryId);
        }

        $botman->reply($this->answers[$categoryId][$questionId]);

        // Show follow-up options
        $question = Question::create('What would you like to do next?')
            ->addButtons([
                Button::create('↩ Back to Questions')->value("category_{$categoryId}"),
                Button::create('🏠 Back to Main Menu')->value('menu')
            ]);

        $botman->reply($question);
    }
}
