class CreateSupplies < ActiveRecord::Migration[8.0]
  def change
    create_table :supplies do |t|
      t.string :supply_name
      t.integer :unit
      t.timestamps
    end
  end
end
