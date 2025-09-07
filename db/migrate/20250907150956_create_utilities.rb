class CreateUtilities < ActiveRecord::Migration[8.0]
  def change
    create_table :utilities do |t|
      t.integer :type
      t.decimal :fee
      t.integer :unit
      t.boolean :is_required
      t.timestamps
    end
  end
end
