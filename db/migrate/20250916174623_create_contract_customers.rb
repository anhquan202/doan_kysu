class CreateContractCustomers < ActiveRecord::Migration[8.0]
  def change
    create_table :contract_customers do |t|
      t.references :contract, null: false, foreign_key: true
      t.references :customer, null: false, foreign_key: true
      t.boolean :is_represent, default: false, null: false
      t.timestamps
    end
  end
end
