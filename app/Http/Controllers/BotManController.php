<?php
namespace App\Http\Controllers;
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class BotManController extends Controller
{
    /**
     * Handle the incoming messages from the Botman chatbot.
     */
    public function handle()
    {
        $botman = app('botman');

        // Listen for "help" or "questions" commands
        $botman->hears('(help|questions|menu)', function($botman) {
            $this->showCategoriesList($botman);
        });

        // Handle button payloads for categories
        $botman->hears('category_([1-4])', function($botman, $category) {
            $this->showQuestionsForCategory($botman, (int)$category);
        });

        // Handle button payloads for specific questions
        $botman->hears('question_([1-4])_([1-9])', function($botman, $category, $question) {
            $this->answerSpecificQuestion($botman, (int)$category, (int)$question);
        });

        // Listen for initial greeting
        $botman->hears('(hi|hello|hey)', function($botman) {
            $botman->reply('👋 Hello! I can help answer your questions about our paddy products.');
            $this->showCategoriesList($botman);
        });

        // Default fallback for unrecognized messages
        $botman->fallback(function($botman) {
            $botman->reply("I'm not sure how to respond to that. Please type 'menu' to see what I can help you with.");
        });

        $botman->listen();
    }

    /**
     * Display the categories of questions as buttons
     */
    public function showCategoriesList($botman)
    {
        $question = Question::create('Please choose a category:')
            ->addButtons([
                Button::create('Quality & Inspection')->value('category_1'),
                Button::create('Pricing & Payment')->value('category_2'),
                Button::create('Product Details')->value('category_3'),
                Button::create('Delivery & Logistics')->value('category_4'),
            ]);

        $botman->reply($question);
    }

    /**
     * Display questions for a specific category as buttons
     */
    public function showQuestionsForCategory($botman, $category)
    {
        $categoryNames = [
            1 => '📋 Quality & Inspection',
            2 => '💰 Pricing & Payment',
            3 => '🌾 Product Details',
            4 => '🚚 Delivery & Logistics'
        ];
        
        $botman->reply("You selected: " . $categoryNames[$category]);
        
        $buttons = [];
        
        switch ($category) {
            case 1:
                $buttons[] = Button::create('Does the paddy meet any quality certifications?')->value('question_1_1');
                break;
                
            case 2:
                $buttons[] = Button::create('Is the listed price negotiable?')->value('question_2_1');
                $buttons[] = Button::create('Are there any discounts for large orders?')->value('question_2_2');
                $buttons[] = Button::create('What payment methods are supported?')->value('question_2_3');
                $buttons[] = Button::create('Is full payment required at delivery?')->value('question_2_4');
                $buttons[] = Button::create('Will I get a receipt for my payment?')->value('question_2_5');
                $buttons[] = Button::create('Can I pay partially in advance?')->value('question_2_6');
                $buttons[] = Button::create('What happens if I refuse the delivery?')->value('question_2_7');
                break;
                
            case 3:
                $buttons[] = Button::create('What varieties of paddy are currently available?')->value('question_3_1');
                $buttons[] = Button::create('What is the standard moisture content for paddy?')->value('question_3_2');
                $buttons[] = Button::create('How is paddy quality verified?')->value('question_3_3');
                $buttons[] = Button::create('Where is the paddy sourced from?')->value('question_3_4');
                $buttons[] = Button::create('What certifications does the paddy have?')->value('question_3_5');
                break;
                
            case 4:
                $buttons[] = Button::create('How long will delivery take?')->value('question_4_1');
                $buttons[] = Button::create('Is delivery included in the price?')->value('question_4_2');
                $buttons[] = Button::create('Who handles delivery?')->value('question_4_3');
                break;
                
            default:
                $botman->reply("Please choose a valid category.");
                $this->showCategoriesList($botman);
                return;
        }
        
        // Add a "Back to Menu" button
        $buttons[] = Button::create('↩ Back to Main Menu')->value('menu');
        
        $question = Question::create('Please select a question:')
            ->addButtons($buttons);
            
        $botman->reply($question);
    }

    /**
     * Answer a specific question based on category and question number
     */
    public function answerSpecificQuestion($botman, $category, $question)
    {
        $answers = [
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

        if (isset($answers[$category][$question])) {
            $botman->reply($answers[$category][$question]);
            
            // Create buttons for next actions
            $question = Question::create('What would you like to do next?')
                ->addButtons([
                    Button::create('↩ Back to Questions')->value('category_' . $category),
                    Button::create('🏠 Back to Main Menu')->value('menu')
                ]);
                
            $botman->reply($question);
        } else {
            $botman->reply("That question doesn't exist in this category.");
            $this->showQuestionsForCategory($botman, $category);
        }
    }
}