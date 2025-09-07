class CreateVehicles < ActiveRecord::Migration[8.0]
  def change
    create_table :vehicles do |t|
      t.references :customer
      t.integer :type
      t.string :license_plate_number
      t.timestamps
    end
  end
end
