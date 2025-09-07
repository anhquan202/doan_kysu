class CreateContractUtilities < ActiveRecord::Migration[8.0]
  def change
    create_table :contract_utilities do |t|
      t.references :contract, null: false, foreign_key: true
      t.references :utility, null: false, foreign_key: true

      t.timestamps
    end
  end
end
