class CreateCustomers < ActiveRecord::Migration[8.0]
  def change
    create_table :customers do |t|
      t.string :first_name
      t.string :last_name
      t.string :address
      t.string :email
      t.string :phone_number
      t.integer :gender
      t.string :avatar
      t.integer :status
      t.timestamps
    end
  end
end
