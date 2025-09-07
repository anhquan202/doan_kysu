class CreateRooms < ActiveRecord::Migration[8.0]
  def change
    create_table :rooms do |t|
      t.integer :room_type
      t.string :room_code
      t.decimal :price, precision: 10, scale: 2
      t.integer :max_customer

      t.timestamps
    end
  end
end
