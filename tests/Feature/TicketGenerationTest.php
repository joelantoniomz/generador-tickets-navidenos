<?php
namespace Tests\Feature;
use Tests\TestCase; use App\Models\User; use Illuminate\Foundation\Testing\RefreshDatabase;
class TicketGenerationTest extends TestCase { use RefreshDatabase; public function test_operator_can_generate_ticket_range():void{$u=User::factory()->create();$this->actingAs($u)->post('/tickets',['quantity'=>5,'per_sheet'=>2])->assertRedirect('/historial');$this->assertDatabaseHas('ticket_batches',['quantity'=>5,'start_number'=>1,'end_number'=>5]);} public function test_quantity_is_validated():void{$u=User::factory()->create();$this->actingAs($u)->post('/tickets',['quantity'=>0,'per_sheet'=>2])->assertSessionHasErrors('quantity');} }
